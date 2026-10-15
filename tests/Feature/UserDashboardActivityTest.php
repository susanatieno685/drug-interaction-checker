<?php

namespace Tests\Feature;

use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Models\InteractionSeverity;
use App\Models\User;
use App\Models\UserInteractionCheck;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserDashboardActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_dashboard_starts_with_empty_user_activity_even_when_library_has_interactions(): void
    {
        $user = User::factory()->create();
        $this->createPair(true);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('No recent checks are available yet.')
            ->assertSee('No saved interactions have been added yet.')
            ->assertSee('Total checks')
            ->assertSee('For educational and informational purposes only.')
            ->assertDontSee('Placeholder data');

        $this->assertDatabaseCount('user_interaction_checks', 0);
    }

    public function test_successful_authenticated_check_updates_only_the_users_dashboard_metrics(): void
    {
        [$drugA, $drugB] = $this->createPair(true);
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('interaction.check'), [
            'drug_a_id' => $drugA->id,
            'drug_b_id' => $drugB->id,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('user_interaction_checks', [
            'user_id' => $user->id,
            'drug_interaction_id' => DrugInteraction::first()->id,
        ]);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('1', false)
            ->assertSee('Warfarin + Ibuprofen')
            ->assertSee('Major');
    }

    public function test_authenticated_no_match_check_is_recorded_without_inventing_a_severity(): void
    {
        [$drugA, $drugB] = $this->createPair(false);
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('interaction.check'), [
            'drug_a_id' => $drugA->id,
            'drug_b_id' => $drugB->id,
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('user_interaction_checks', [
            'user_id' => $user->id,
            'drug_interaction_id' => null,
        ]);

        $this->actingAs($user)->get(route('dashboard'))
            ->assertOk()
            ->assertSee('No match recorded');
    }

    public function test_invalid_check_does_not_update_user_metrics(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->from(route('dashboard'))->post(route('interaction.check'), [
            'drug_a_id' => 123456,
            'drug_b_id' => 123457,
        ])->assertRedirect(route('dashboard'))
            ->assertSessionHasErrors(['drug_a_id', 'drug_b_id']);

        $this->assertDatabaseCount('user_interaction_checks', 0);
    }

    private function createPair(bool $withInteraction): array
    {
        $drugA = Drug::create([
            'generic_name' => 'Warfarin', 'is_active' => true,
        ]);
        $drugB = Drug::create([
            'generic_name' => 'Ibuprofen', 'is_active' => true,
        ]);

        if ($withInteraction) {
            $severity = InteractionSeverity::create([
                'name' => 'Major', 'slug' => 'major', 'description' => 'Major interaction',
                'bootstrap_class' => 'warning', 'priority' => 1,
            ]);
            DrugInteraction::create([
                'drug_a_id' => min($drugA->id, $drugB->id),
                'drug_b_id' => max($drugA->id, $drugB->id),
                'interaction_severity_id' => $severity->id,
                'mechanism' => 'Test mechanism', 'clinical_effect' => 'Test effect',
                'management' => 'Test management', 'is_active' => true,
            ]);
        }

        return [$drugA, $drugB];
    }
}
