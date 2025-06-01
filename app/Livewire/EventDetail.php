<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventDetail extends Component
{
    public $eventId;
    public $event;

    protected $listeners = [
        'refreshEvent' => '$refresh',
    ];

    public function mount($event)
    {
        $this->eventId = $event;

        $this->loadEvent();
    }

    public function loadEvent()
    {
        $userId = Auth::id();

        $this->event = Event::with([
            'creator',
            'eventFor',
            'invitations',
            'requisitionItems',
            'photos',
        ])
        ->where(function ($query) use ($userId) {
            $query->where('creator_id', $userId)
                  ->orWhere('event_for', $userId)
                  ->orWhereHas('invitations', function ($q) use ($userId) {
                      $q->where('user_id', $userId);
                  });
        })
        ->findOrFail($this->eventId);
    }

    public function render()
    {
        return view('livewire.event-detail')->layout('layouts.app');
    }
}
