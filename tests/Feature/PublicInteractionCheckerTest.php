<?php

namespace Tests\Feature;

use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Models\InteractionSeverity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicInteractionCheckerTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_existing_interaction_is_returned(): void
    {
        [$drugA, $drugB, $severity] = $this->seedInteractionPair();

        $response = $this->post(route('interaction.check'), [
            'drug_a_id' => $drugA->id,
            'drug_b_id' => $drugB->id,
        ]);

        $response->assertOk();
        $response->assertSee($drugA->generic_name);
        $response->assertSee($drugB->generic_name);
        $response->assertSee($severity->name);
        $response->assertSee('Current database match');
    }

    public function test_reversed_drug_order_returns_the_same_interaction(): void
    {
        [$drugA, $drugB, $severity] = $this->seedInteractionPair();

        $response = $this->post(route('interaction.check'), [
            'drug_a_id' => $drugB->id,
            'drug_b_id' => $drugA->id,
        ]);

        $response->assertOk();
        $response->assertSee($drugA->generic_name);
        $response->assertSee($drugB->generic_name);
        $response->assertSee($severity->name);
        $response->assertSee('Current database match');
    }

    public function test_selecting_the_same_drug_fails_validation(): void
    {
        $drug = Drug::create([
            'generic_name' => 'Test Drug',
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

        $response = $this->from(route('home'))->post(route('interaction.check'), [
            'drug_a_id' => $drug->id,
            'drug_b_id' => $drug->id,
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors(['drug_b_id']);
        $response->assertSessionHasErrors([
            'drug_b_id' => 'Please choose two different drugs.',
        ]);
    }

    public function test_invalid_drug_ids_fail_validation(): void
    {
        $response = $this->from(route('home'))->post(route('interaction.check'), [
            'drug_a_id' => 999999,
            'drug_b_id' => 888888,
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors(['drug_a_id', 'drug_b_id']);
    }

    public function test_an_unknown_pair_shows_the_database_limitation_message(): void
    {
        $drugA = Drug::create([
            'generic_name' => 'Unknown A',
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

        $drugB = Drug::create([
            'generic_name' => 'Unknown B',
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

        $response = $this->post(route('interaction.check'), [
            'drug_a_id' => $drugA->id,
            'drug_b_id' => $drugB->id,
        ]);

        $response->assertOk();
        $response->assertSee("No interaction was found in this application's current database.");
    }

    private function seedInteractionPair(): array
    {
        $severity = InteractionSeverity::create([
            'name' => 'Major',
            'slug' => 'major',
            'description' => 'Major interaction',
            'bootstrap_class' => 'warning',
            'priority' => 1,
        ]);

        $drugA = Drug::create([
            'generic_name' => 'Warfarin',
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

        $drugB = Drug::create([
            'generic_name' => 'Ibuprofen',
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

        return [$drugA, $drugB, $severity];
    }
}
