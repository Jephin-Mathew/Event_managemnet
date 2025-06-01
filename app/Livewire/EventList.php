<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;

class EventList extends Component
{
    public $events;

    public function mount()
    {
        $userId = Auth::id();

        $this->events = Event::where('creator_id', $userId)
            ->orWhere('event_for', $userId)
            ->orWhereHas('invitations', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderBy('date', 'desc')
            ->get();
    }

    public function render()
    {
    return view('livewire.event-list')->layout('layouts.app');
    }
}
