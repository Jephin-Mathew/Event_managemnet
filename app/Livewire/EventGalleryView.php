<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class EventGalleryView extends Component
{
    public $eventId;
    public $event;
    public $photos;

    public function mount($event)
    {
        $this->eventId = $event;
        $this->loadGallery();
    }

    public function loadGallery()
    {
        $userId = Auth::id();

        $this->event = Event::with(['photos.user', 'creator', 'eventFor'])
            ->where(function ($query) use ($userId) {
                $query->where('creator_id', $userId)
                      ->orWhere('event_for', $userId)
                      ->orWhereHas('invitations', function ($q) use ($userId) {
                          $q->where('user_id', $userId);
                      });
            })
            ->findOrFail($this->eventId);

        $this->photos = $this->event->photos()->with('user')->get();
    }

    public function render()
    {
        return view('livewire.event-gallery-view')->layout('layouts.app');
    }
}
