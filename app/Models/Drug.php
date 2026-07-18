<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Drug extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'generic_name',
        'brand_name',
        'drug_class',
        'dosage_form',
        'strength',
        'description',
        'contraindications',
        'warnings',
        'storage_information',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function drugInteractionsAsFirstDrug(): HasMany
    {
        return $this->hasMany(DrugInteraction::class, 'drug_a_id');
    }

    public function drugInteractionsAsSecondDrug(): HasMany
    {
        return $this->hasMany(DrugInteraction::class, 'drug_b_id');
    }

    public function isReferencedByAnyInteraction(): bool
    {
        return $this->drugInteractionsAsFirstDrug()->exists()
            || $this->drugInteractionsAsSecondDrug()->exists();
    }
}
