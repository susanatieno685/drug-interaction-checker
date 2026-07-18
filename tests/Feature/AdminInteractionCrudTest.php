<?php

namespace Tests\Feature;

use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Models\InteractionSeverity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminInteractionCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_an_interaction(): void
    {
        $admin = $this->makeAdmin();
        [$drugA, $drugB, $severity] = $this->makeDrugPairAndSeverity();

        $response = $this->actingAs($admin)->post(route('admin.interactions.store'), [
            'drug_a_id' => $drugA->id,
            'drug_b_id' => $drugB->id,
            'interaction_severity_id' => $severity->id,
            'mechanism' => 'Test mechanism',
            'clinical_effect' => 'Test effect',
            'management' => 'Test management',
            'monitoring_advice' => 'Test monitoring',
            'evidence_level' => 'High',
            'reference' => 'Test reference',
            'notes' => 'Test notes',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.interactions.index'));
        $response->assertSessionHas('success', 'Interaction created successfully.');

        $this->assertDatabaseHas('drug_interactions', [
            'drug_a_id' => min($drugA->id, $drugB->id),
            'drug_b_id' => max($drugA->id, $drugB->id),
            'interaction_severity_id' => $severity->id,
            'mechanism' => 'Test mechanism',
            'is_active' => 1,
        ]);
    }

    public function test_drug_order_is_normalized_on_create(): void
    {
        $admin = $this->makeAdmin();
        [$drugA, $drugB, $severity] = $this->makeDrugPairAndSeverity();

        $response = $this->actingAs($admin)->post(route('admin.interactions.store'), [
            'drug_a_id' => $drugB->id,
            'drug_b_id' => $drugA->id,
            'interaction_severity_id' => $severity->id,
            'mechanism' => 'Test mechanism',
            'clinical_effect' => 'Test effect',
            'management' => 'Test management',
            'monitoring_advice' => null,
            'evidence_level' => 'High',
            'reference' => 'Test reference',
            'notes' => null,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.interactions.index'));

        $this->assertDatabaseHas('drug_interactions', [
            'drug_a_id' => min($drugA->id, $drugB->id),
            'drug_b_id' => max($drugA->id, $drugB->id),
        ]);
    }

    public function test_duplicate_reversed_pairs_are_rejected(): void
    {
        $admin = $this->makeAdmin();
        [$drugA, $drugB, $severity] = $this->makeDrugPairAndSeverity();
        $this->createInteraction($drugA, $drugB, $severity);

        $response = $this->actingAs($admin)->from(route('admin.interactions.create'))->post(route('admin.interactions.store'), [
            'drug_a_id' => $drugB->id,
            'drug_b_id' => $drugA->id,
            'interaction_severity_id' => $severity->id,
            'mechanism' => 'Duplicate mechanism',
            'clinical_effect' => 'Duplicate effect',
            'management' => 'Duplicate management',
            'monitoring_advice' => null,
            'evidence_level' => 'High',
            'reference' => 'Duplicate reference',
            'notes' => null,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.interactions.create'));
        $response->assertSessionHasErrors(['drug_b_id']);
    }

    public function test_identical_drug_ids_are_rejected(): void
    {
        $admin = $this->makeAdmin();
        $drug = $this->makeDrug('Single Drug');
        $severity = $this->makeSeverity();

        $response = $this->actingAs($admin)->from(route('admin.interactions.create'))->post(route('admin.interactions.store'), [
            'drug_a_id' => $drug->id,
            'drug_b_id' => $drug->id,
            'interaction_severity_id' => $severity->id,
            'mechanism' => 'Same drug mechanism',
            'clinical_effect' => 'Same drug effect',
            'management' => 'Same drug management',
            'monitoring_advice' => null,
            'evidence_level' => 'Low',
            'reference' => 'Same drug reference',
            'notes' => null,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.interactions.create'));
        $response->assertSessionHasErrors(['drug_a_id', 'drug_b_id']);
    }

    public function test_admin_can_update_and_delete_an_interaction(): void
    {
        $admin = $this->makeAdmin();
        [$drugA, $drugB, $severity] = $this->makeDrugPairAndSeverity();
        $interaction = $this->createInteraction($drugA, $drugB, $severity);

        $drugC = $this->makeDrug('Updated Drug');
        $severityTwo = $this->makeSeverity('Minor', 'minor', 2, 'secondary');

        $updateResponse = $this->actingAs($admin)->put(route('admin.interactions.update', $interaction), [
            'drug_a_id' => $drugA->id,
            'drug_b_id' => $drugC->id,
            'interaction_severity_id' => $severityTwo->id,
            'mechanism' => 'Updated mechanism',
            'clinical_effect' => 'Updated effect',
            'management' => 'Updated management',
            'monitoring_advice' => 'Updated monitoring',
            'evidence_level' => 'Moderate',
            'reference' => 'Updated reference',
            'notes' => 'Updated notes',
            'is_active' => false,
        ]);

        $updateResponse->assertRedirect(route('admin.interactions.index'));
        $updateResponse->assertSessionHas('success', 'Interaction updated successfully.');

        $this->assertDatabaseHas('drug_interactions', [
            'id' => $interaction->id,
            'drug_a_id' => min($drugA->id, $drugC->id),
            'drug_b_id' => max($drugA->id, $drugC->id),
            'interaction_severity_id' => $severityTwo->id,
            'mechanism' => 'Updated mechanism',
            'is_active' => 0,
        ]);

        $deleteResponse = $this->actingAs($admin)->delete(route('admin.interactions.destroy', $interaction));

        $deleteResponse->assertRedirect(route('admin.interactions.index'));
        $deleteResponse->assertSessionHas('success', 'Interaction deleted successfully.');

        $this->assertDatabaseMissing('drug_interactions', [
            'id' => $interaction->id,
        ]);
    }

    private function makeAdmin(): User
    {
        return User::create([
            'name' => 'Admin User',
            'email' => fake()->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }

    private function makeDrug(string $name): Drug
    {
        return Drug::create([
            'generic_name' => $name,
            'brand_name' => null,
            'drug_class' => null,
            'dosage_form' => null,
            'strength' => null,
            'description' => null,
            'contraindications' => null,
            'warnings' => null,
            'storage_information' => null,
            'is_active' => true,
        ]);
    }

    /**
     * @return array{0:Drug,1:Drug,2:InteractionSeverity}
     */
    private function makeDrugPairAndSeverity(): array
    {
        return [
            $this->makeDrug('Warfarin'),
            $this->makeDrug('Ibuprofen'),
            $this->makeSeverity(),
        ];
    }

    private function makeSeverity(string $name = 'Major', string $slug = 'major', int $priority = 1, string $bootstrapClass = 'warning'): InteractionSeverity
    {
        return InteractionSeverity::create([
            'name' => $name,
            'slug' => $slug,
            'description' => $name . ' interaction',
            'bootstrap_class' => $bootstrapClass,
            'priority' => $priority,
        ]);
    }

    private function createInteraction(Drug $drugA, Drug $drugB, InteractionSeverity $severity): DrugInteraction
    {
        return DrugInteraction::create([
            'drug_a_id' => min($drugA->id, $drugB->id),
            'drug_b_id' => max($drugA->id, $drugB->id),
            'interaction_severity_id' => $severity->id,
            'mechanism' => 'Test mechanism',
            'clinical_effect' => 'Test effect',
            'management' => 'Test management',
            'monitoring_advice' => null,
            'evidence_level' => 'High',
            'reference' => 'Test reference',
            'notes' => null,
            'is_active' => true,
        ]);
    }
}
