<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EventCreate extends Component
{
    public $title;
    public $date;
    public $time;
    public $event_type;
    public $event_for;
    public $event_guidelines;
    public $invited_user_ids = [];

    public $users = [];

    public $eventTypes = ['meeting', 'celebration', 'seminar'];




    public function mount()
    {

        $this->users = User::all();
        $this->event_for = Auth::id();
    }

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'time' => 'required|date_format:H:i',
            'event_type' => ['required', Rule::in($this->eventTypes)],


            'event_for' => ['required', 'exists:users,id'],
            'event_guidelines' => 'nullable|string',
            'invited_user_ids' => 'nullable|array',
            'invited_user_ids.*' => 'exists:users,id|different:event_for',
        ];
    }

    public function createEvent()
    {
        logger()->info('Submitted event_type:', ['event_type' => $this->event_type]);


        // $this->event_type = ucfirst(strtolower($this->event_type));

        $this->validate();

        $event = Event::create([
            'title' => $this->title,
            'date' => $this->date,
            'time' => $this->time,
            'event_type' => $this->event_type,
            'creator_id' => Auth::id(),
            'event_for' => $this->event_for,
            'event_guidelines' => $this->event_guidelines,
        ]);


        foreach ($this->invited_user_ids as $userId) {
            $event->invitations()->create([
                'user_id' => $userId,
                'status' => 'pending',
            ]);
        }

        session()->flash('message', 'Event created and invitations sent!');

        return redirect()->route('events.list');
    }

    public function render()
    {
        return view('livewire.event-create')->layout('layouts.app');
    }
}
