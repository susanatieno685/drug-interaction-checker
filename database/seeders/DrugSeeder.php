<?php

namespace Database\Seeders;

use App\Models\Drug;
use Illuminate\Database\Seeder;

class DrugSeeder extends Seeder
{
    /**
     * Seed common drug records for Version 1.
     */
    public function run(): void
    {
        $drugs = [
            ['generic_name' => 'Paracetamol', 'brand_name' => null, 'drug_class' => 'Analgesic', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Ibuprofen', 'brand_name' => null, 'drug_class' => 'NSAID', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Aspirin', 'brand_name' => null, 'drug_class' => 'Antiplatelet / NSAID', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Warfarin', 'brand_name' => null, 'drug_class' => 'Anticoagulant', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Metformin', 'brand_name' => null, 'drug_class' => 'Antidiabetic', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Amlodipine', 'brand_name' => null, 'drug_class' => 'Calcium channel blocker', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Losartan', 'brand_name' => null, 'drug_class' => 'ARB', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Enalapril', 'brand_name' => null, 'drug_class' => 'ACE inhibitor', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Omeprazole', 'brand_name' => null, 'drug_class' => 'Proton pump inhibitor', 'dosage_form' => 'Capsule', 'strength' => null],
            ['generic_name' => 'Clopidogrel', 'brand_name' => null, 'drug_class' => 'Antiplatelet', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Amoxicillin', 'brand_name' => null, 'drug_class' => 'Penicillin antibiotic', 'dosage_form' => 'Capsule', 'strength' => null],
            ['generic_name' => 'Azithromycin', 'brand_name' => null, 'drug_class' => 'Macrolide antibiotic', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Ciprofloxacin', 'brand_name' => null, 'drug_class' => 'Fluoroquinolone antibiotic', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Metronidazole', 'brand_name' => null, 'drug_class' => 'Nitroimidazole antibiotic', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Diclofenac', 'brand_name' => null, 'drug_class' => 'NSAID', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Atorvastatin', 'brand_name' => null, 'drug_class' => 'Statin', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Simvastatin', 'brand_name' => null, 'drug_class' => 'Statin', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Carbamazepine', 'brand_name' => null, 'drug_class' => 'Antiepileptic', 'dosage_form' => 'Tablet', 'strength' => null],
            ['generic_name' => 'Phenytoin', 'brand_name' => null, 'drug_class' => 'Antiepileptic', 'dosage_form' => 'Capsule', 'strength' => null],
            ['generic_name' => 'Insulin', 'brand_name' => null, 'drug_class' => 'Antidiabetic', 'dosage_form' => 'Injection', 'strength' => null],
        ];

        foreach ($drugs as $drug) {
            Drug::updateOrCreate(
                ['generic_name' => $drug['generic_name']],
                [
                    'brand_name' => $drug['brand_name'],
                    'drug_class' => $drug['drug_class'],
                    'dosage_form' => $drug['dosage_form'],
                    'strength' => $drug['strength'],
                    'description' => null,
                    'contraindications' => null,
                    'warnings' => null,
                    'storage_information' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}
