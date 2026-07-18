<?php

namespace Database\Seeders;

use App\Models\Drug;
use App\Models\DrugInteraction;
use App\Models\InteractionSeverity;
use App\Services\DrugPairNormalizer;
use Illuminate\Database\Seeder;

class DrugInteractionSeeder extends Seeder
{
    /**
     * Clinical content requires pharmacist review before use.
     */
    public function run(): void
    {
        $normalizer = new DrugPairNormalizer();

        $drugs = Drug::query()
            ->whereIn('generic_name', [
                'Warfarin',
                'Ibuprofen',
                'Aspirin',
                'Metronidazole',
                'Ciprofloxacin',
                'Enalapril',
                'Losartan',
                'Clopidogrel',
                'Omeprazole',
                'Carbamazepine',
                'Phenytoin',
                'Simvastatin',
                'Azithromycin',
            ])
            ->get()
            ->keyBy('generic_name');

        $severities = InteractionSeverity::query()
            ->get()
            ->keyBy('slug');

        $records = [
            [
                'drug_a' => 'Warfarin',
                'drug_b' => 'Ibuprofen',
                'severity' => 'major',
                'mechanism' => 'NSAID therapy can increase bleeding risk when used with anticoagulants.',
                'clinical_effect' => 'Increased risk of gastrointestinal bleeding and other hemorrhagic events.',
                'management' => 'Avoid if possible. Consider alternative analgesics and assess bleeding risk closely if combined.',
                'monitoring_advice' => 'Monitor for bruising, melena, hematuria, and changes in INR when clinically appropriate.',
                'evidence_level' => 'High',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Warfarin',
                'drug_b' => 'Aspirin',
                'severity' => 'major',
                'mechanism' => 'Combined anticoagulant and antiplatelet effects increase bleeding risk.',
                'clinical_effect' => 'Higher likelihood of major bleeding, especially gastrointestinal bleeding.',
                'management' => 'Use only when clearly indicated and with careful risk-benefit review.',
                'monitoring_advice' => 'Monitor for bleeding signs and reassess need for dual therapy regularly.',
                'evidence_level' => 'High',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Warfarin',
                'drug_b' => 'Metronidazole',
                'severity' => 'contraindicated',
                'mechanism' => 'Metronidazole can inhibit warfarin metabolism and increase anticoagulant effect.',
                'clinical_effect' => 'INR elevation and increased bleeding risk.',
                'management' => 'Avoid when possible. If unavoidable, intensify INR monitoring and adjust anticoagulation as needed.',
                'monitoring_advice' => 'Check INR closely and monitor for bleeding.',
                'evidence_level' => 'High',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Warfarin',
                'drug_b' => 'Ciprofloxacin',
                'severity' => 'major',
                'mechanism' => 'Ciprofloxacin may enhance warfarin effect through metabolic and gut-flora related mechanisms.',
                'clinical_effect' => 'Possible INR increase and bleeding risk.',
                'management' => 'Use caution and monitor anticoagulation more frequently during coadministration.',
                'monitoring_advice' => 'Monitor INR and bleeding symptoms.',
                'evidence_level' => 'Moderate to high',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Enalapril',
                'drug_b' => 'Losartan',
                'severity' => 'major',
                'mechanism' => 'Dual renin-angiotensin system blockade can increase adverse renal and potassium effects.',
                'clinical_effect' => 'Risk of hypotension, hyperkalemia, and reduced renal function.',
                'management' => 'Generally avoid routine combination use unless specifically justified and closely supervised.',
                'monitoring_advice' => 'Monitor blood pressure, serum potassium, and renal function.',
                'evidence_level' => 'High',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Clopidogrel',
                'drug_b' => 'Omeprazole',
                'severity' => 'moderate',
                'mechanism' => 'Omeprazole may reduce clopidogrel activation via CYP2C19 inhibition.',
                'clinical_effect' => 'Potential reduction in antiplatelet effect.',
                'management' => 'Consider an alternative acid-suppressing therapy when appropriate or review the indication carefully.',
                'monitoring_advice' => 'Monitor for reduced antiplatelet response when clinically relevant.',
                'evidence_level' => 'Moderate',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Carbamazepine',
                'drug_b' => 'Warfarin',
                'severity' => 'major',
                'mechanism' => 'Carbamazepine may induce warfarin metabolism and lower anticoagulant effect.',
                'clinical_effect' => 'Reduced INR and possible loss of anticoagulation control.',
                'management' => 'Monitor INR carefully and anticipate warfarin dose adjustment if needed.',
                'monitoring_advice' => 'Monitor INR more frequently after carbamazepine changes.',
                'evidence_level' => 'High',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Phenytoin',
                'drug_b' => 'Warfarin',
                'severity' => 'major',
                'mechanism' => 'Bidirectional interaction can alter both anticoagulant and anticonvulsant exposure.',
                'clinical_effect' => 'Unpredictable INR and phenytoin concentrations.',
                'management' => 'Use with caution and monitor both therapies closely.',
                'monitoring_advice' => 'Monitor INR and phenytoin effects/levels when available.',
                'evidence_level' => 'Moderate to high',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Simvastatin',
                'drug_b' => 'Azithromycin',
                'severity' => 'moderate',
                'mechanism' => 'Macrolide antibiotics may raise statin exposure, though azithromycin is less potent than other macrolides.',
                'clinical_effect' => 'Potential increase in statin adverse effects including myopathy.',
                'management' => 'Use caution and monitor for muscle pain or weakness.',
                'monitoring_advice' => 'Monitor for myopathy symptoms and consider temporary statin interruption if clinically appropriate.',
                'evidence_level' => 'Moderate',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Ibuprofen',
                'drug_b' => 'Aspirin',
                'severity' => 'moderate',
                'mechanism' => 'Ibuprofen can interfere with aspirin’s antiplatelet effect and add GI toxicity.',
                'clinical_effect' => 'Potential reduction in aspirin cardioprotection and increased bleeding/GI irritation.',
                'management' => 'Avoid frequent concurrent use when possible or separate timing if advised by a clinician.',
                'monitoring_advice' => 'Monitor for GI bleeding and review antiplatelet benefit if combined.',
                'evidence_level' => 'Moderate',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Metronidazole',
                'drug_b' => 'Phenytoin',
                'severity' => 'moderate',
                'mechanism' => 'Metronidazole can alter phenytoin exposure in some patients.',
                'clinical_effect' => 'Possible phenytoin toxicity or altered seizure control.',
                'management' => 'Monitor closely if used together and review seizure symptoms or adverse effects.',
                'monitoring_advice' => 'Monitor for neurologic toxicity and seizure control.',
                'evidence_level' => 'Moderate',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Ciprofloxacin',
                'drug_b' => 'Phenytoin',
                'severity' => 'moderate',
                'mechanism' => 'Fluoroquinolones can unpredictably affect phenytoin concentrations and seizure threshold.',
                'clinical_effect' => 'Possible changes in phenytoin levels and seizure control.',
                'management' => 'Use caution and monitor neurological status and phenytoin response.',
                'monitoring_advice' => 'Monitor for breakthrough seizures or toxicity.',
                'evidence_level' => 'Moderate',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
            [
                'drug_a' => 'Enalapril',
                'drug_b' => 'Ibuprofen',
                'severity' => 'moderate',
                'mechanism' => 'NSAIDs can reduce antihypertensive response and contribute to renal effects with ACE inhibitors.',
                'clinical_effect' => 'Reduced blood pressure control and increased renal risk in susceptible patients.',
                'management' => 'Use caution, especially in older adults or those with kidney disease or dehydration.',
                'monitoring_advice' => 'Monitor blood pressure, renal function, and hydration status.',
                'evidence_level' => 'Moderate',
                'reference' => 'Clinical reference pending verification.',
                'notes' => null,
            ],
        ];

        foreach ($records as $record) {
            $drugOne = $drugs->get($record['drug_a']);
            $drugTwo = $drugs->get($record['drug_b']);

            if (! $drugOne || ! $drugTwo) {
                continue;
            }

            [$drugAId, $drugBId] = $normalizer->normalize($drugOne->id, $drugTwo->id);

            DrugInteraction::updateOrCreate(
                [
                    'drug_a_id' => $drugAId,
                    'drug_b_id' => $drugBId,
                ],
                [
                    'interaction_severity_id' => $severities->get($record['severity'])?->id,
                    'mechanism' => $record['mechanism'],
                    'clinical_effect' => $record['clinical_effect'],
                    'management' => $record['management'],
                    'monitoring_advice' => $record['monitoring_advice'],
                    'evidence_level' => $record['evidence_level'],
                    'reference' => $record['reference'],
                    'notes' => $record['notes'],
                    'is_active' => true,
                ]
            );
        }
    }

}
