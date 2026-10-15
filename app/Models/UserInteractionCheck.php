<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserInteractionCheck extends Model
{
    protected $fillable = [
        'user_id',
        'drug_a_id',
        'drug_b_id',
        'drug_interaction_id',
    ];

    public function drugA(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'drug_a_id');
    }

    public function drugB(): BelongsTo
    {
        return $this->belongsTo(Drug::class, 'drug_b_id');
    }

    public function interaction(): BelongsTo
    {
        return $this->belongsTo(DrugInteraction::class, 'drug_interaction_id');
    }
}
