<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string,string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function createdEvents()
    {
        return $this->hasMany(Event::class, 'creator_id');
    }

    public function eventsFor()
    {
        return $this->hasMany(Event::class, 'event_for');
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function claimedRequisitionItems()
    {
        return $this->hasMany(RequisitionItem::class, 'claimed_by');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
