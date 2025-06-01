<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'date',
        'time',
        'event_type',
        'creator_id',
        'event_for',
        'event_guidelines',
    ];


    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function eventFor()
    {
        return $this->belongsTo(User::class, 'event_for');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function requisitionItems()
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
