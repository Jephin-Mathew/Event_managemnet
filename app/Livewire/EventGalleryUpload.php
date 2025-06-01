<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Event;
use App\Models\Photo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EventGalleryUpload extends Component
{
    use WithFileUploads;

    public $eventId;
    public $event;
    public $photo;

    public function mount($event)
    {
        $this->eventId = $event;
        $this->loadEvent();
    }

    public function loadEvent()
    {
        $userId = Auth::id();

        $this->event = Event::where(function ($query) use ($userId) {
                $query->where('creator_id', $userId)
                      ->orWhere('event_for', $userId)
                      ->orWhereHas('invitations', function ($q) use ($userId) {
                          $q->where('user_id', $userId);
                      });
            })
            ->findOrFail($this->eventId);
    }

    protected function rules()
    {
        return [
            'photo' => 'required|image|max:5120',
        ];
    }

    public function uploadPhoto()
    {
        $userId = Auth::id();

        $isAllowed = $this->event->creator_id === $userId
            || $this->event->event_for === $userId
            || $this->event->invitations()->where('user_id', $userId)->exists();

        if (! $isAllowed) {
            throw ValidationException::withMessages([
                'photo' => 'You are not authorized to upload photos for this event.'
            ]);
        }

        $this->validate();

        $filename = $this->photo->store('event_photos', 'public');

        Photo::create([
            'event_id' => $this->eventId,
            'user_id' => $userId,
            'filepath' => $filename,
        ]);

        session()->flash('message', 'Photo uploaded successfully!');
        $this->photo = null;

        $this->dispatch('refreshGallery');
    }

    public function render()
    {
        return view('livewire.event-gallery-upload')->layout('layouts.app');
    }
}
