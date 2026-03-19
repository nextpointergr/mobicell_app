<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierFieldMapping extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'source_field',
        'target_table',
        'target_field',
        'required',
        'active',
        // --- ΝΕΑ ΠΕΔΙΑ ΓΙΑ SMART SYNC ---
        'is_hashable',       // Αν αυτό το πεδίο επηρεάζει το md5 hash (αλλαγή προϊόντος)
        'is_unique_check',   // Αν πρέπει να ελέγχεται για διπλότυπα (π.χ. EAN, MPN)
        'ignore_if_exists',  // Αν η τιμή υπάρχει ήδη, να αγνοείται όλο το record
    ];

    /**
     * Casting για να τα διαχειρίζεσαι ως booleans στο Livewire/Logic
     */
    protected $casts = [
        'required' => 'boolean',
        'active' => 'boolean',
        'is_hashable' => 'boolean',
        'is_unique_check' => 'boolean',
        'ignore_if_exists' => 'boolean',
    ];

    /**
     * Σχέση με τον Προμηθευτή
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }
}
