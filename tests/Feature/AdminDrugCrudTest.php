<?php

namespace Tests\Feature;

use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Models\InteractionSeverity;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminDrugCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_drug(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post(route('admin.drugs.store'), [
            'generic_name' => 'Paracetamol',
            'brand_name' => 'Acetaminophen',
            'drug_class' => 'Analgesic',
            'dosage_form' => 'Tablet',
            'strength' => '500 mg',
            'description' => 'Pain reliever',
            'contraindications' => 'None',
            'warnings' => 'Use as directed',
            'storage_information' => 'Store in a cool dry place',
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.drugs.index'));
        $response->assertSessionHas('success', 'Drug created successfully.');

        $this->assertDatabaseHas('drugs', [
            'generic_name' => 'Paracetamol',
            'brand_name' => 'Acetaminophen',
            'is_active' => 1,
        ]);
    }

    public function test_validation_errors_are_returned_for_invalid_drugs(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->from(route('admin.drugs.create'))->post(route('admin.drugs.store'), [
            'generic_name' => '',
            'is_active' => 'not-a-boolean',
        ]);

        $response->assertRedirect(route('admin.drugs.create'));
        $response->assertSessionHasErrors(['generic_name', 'is_active']);
    }

    public function test_admin_can_update_a_drug(): void
    {
        $admin = $this->makeAdmin();
        $drug = $this->makeDrug(['generic_name' => 'Ibuprofen', 'brand_name' => null]);

        $response = $this->actingAs($admin)->put(route('admin.drugs.update', $drug), [
            'generic_name' => 'Ibuprofen Updated',
            'brand_name' => 'Updated Brand',
            'drug_class' => 'NSAID',
            'dosage_form' => 'Tablet',
            'strength' => '400 mg',
            'description' => 'Updated description',
            'contraindications' => 'Updated contraindications',
            'warnings' => 'Updated warnings',
            'storage_information' => 'Updated storage',
            'is_active' => false,
        ]);

        $response->assertRedirect(route('admin.drugs.index'));
        $response->assertSessionHas('success', 'Drug updated successfully.');

        $this->assertDatabaseHas('drugs', [
            'id' => $drug->id,
            'generic_name' => 'Ibuprofen Updated',
            'brand_name' => 'Updated Brand',
            'is_active' => 0,
        ]);
    }

    public function test_admin_can_delete_an_unused_drug(): void
    {
        $admin = $this->makeAdmin();
        $drug = $this->makeDrug(['generic_name' => 'Unused Drug']);

        $response = $this->actingAs($admin)->delete(route('admin.drugs.destroy', $drug));

        $response->assertRedirect(route('admin.drugs.index'));
        $response->assertSessionHas('success', 'Drug deleted successfully.');

        $this->assertDatabaseMissing('drugs', [
            'id' => $drug->id,
        ]);
    }

    public function test_a_referenced_drug_cannot_be_deleted(): void
    {
        $admin = $this->makeAdmin();
        [$drugA, $drugB] = $this->makeReferencedPair();

        $response = $this->actingAs($admin)->delete(route('admin.drugs.destroy', $drugA));

        $response->assertRedirect(route('admin.drugs.index'));
        $response->assertSessionHas('warning', 'This drug is used in one or more interactions. Deactivate it instead of deleting it.');

        $this->assertDatabaseHas('drugs', [
            'id' => $drugA->id,
        ]);
        $this->assertDatabaseHas('drugs', [
            'id' => $drugB->id,
        ]);
        $this->assertDatabaseHas('drug_interactions', [
            'drug_a_id' => min($drugA->id, $drugB->id),
            'drug_b_id' => max($drugA->id, $drugB->id),
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

    private function makeDrug(array $overrides = []): Drug
    {
        return Drug::create(array_merge([
            'generic_name' => fake()->unique()->word(),
            'brand_name' => null,
            'drug_class' => null,
            'dosage_form' => null,
            'strength' => null,
            'description' => null,
            'contraindications' => null,
            'warnings' => null,
            'storage_information' => null,
            'is_active' => true,
        ], $overrides));
    }

    /**
     * @return array{0:Drug,1:Drug}
     */
    private function makeReferencedPair(): array
    {
        $drugA = $this->makeDrug(['generic_name' => 'Referenced A']);
        $drugB = $this->makeDrug(['generic_name' => 'Referenced B']);

        $severity = InteractionSeverity::create([
            'name' => 'Major',
            'slug' => 'major',
            'description' => 'Major interaction',
            'bootstrap_class' => 'warning',
            'priority' => 1,
        ]);

        DrugInteraction::create([
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

        return [$drugA, $drugB];
    }
}
