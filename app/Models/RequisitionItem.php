<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequisitionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'description',
        'claimed_by',
        'is_gift',
        'is_optional',
        'visibility',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function claimer()
    {
        return $this->belongsTo(User::class, 'claimed_by');
    }
}
