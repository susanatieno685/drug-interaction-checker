<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DrugInteraction extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'drug_a_id',
        'drug_b_id',
        'interaction_severity_id',
        'mechanism',
        'clinical_effect',
        'management',
        'monitoring_advice',
        'evidence_level',
        'reference',
        'notes',
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

    public function drugA(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'drug_a_id');
    }

    public function drugB(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'drug_b_id');
    }

    public function severity(): BelongsTo
    {
        return $this->belongsTo(InteractionSeverity::class, 'interaction_severity_id');
    }
}
