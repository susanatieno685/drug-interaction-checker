<?php

namespace Database\Seeders;

use App\Models\InteractionSeverity;
use Illuminate\Database\Seeder;

class InteractionSeveritySeeder extends Seeder
{
    /**
     * Seed the interaction severity records.
     */
    public function run(): void
    {
        $severities = [
            [
                'name' => 'Contraindicated',
                'slug' => 'contraindicated',
                'description' => 'The combination should generally not be used.',
                'bootstrap_class' => 'danger',
                'priority' => 1,
            ],
            [
                'name' => 'Major',
                'slug' => 'major',
                'description' => 'The combination may cause serious harm and needs strong avoidance or close review.',
                'bootstrap_class' => 'warning',
                'priority' => 2,
            ],
            [
                'name' => 'Moderate',
                'slug' => 'moderate',
                'description' => 'The interaction may require dose adjustment, monitoring, or therapy modification.',
                'bootstrap_class' => 'info',
                'priority' => 3,
            ],
            [
                'name' => 'Minor',
                'slug' => 'minor',
                'description' => 'The interaction is usually mild but may still need awareness.',
                'bootstrap_class' => 'secondary',
                'priority' => 4,
            ],
            [
                'name' => 'No known interaction',
                'slug' => 'no-known-interaction',
                'description' => 'No interaction is currently documented in this application database.',
                'bootstrap_class' => 'success',
                'priority' => 5,
            ],
        ];

        foreach ($severities as $severity) {
            InteractionSeverity::updateOrCreate(
                ['slug' => $severity['slug']],
                $severity
            );
        }
    }
}
