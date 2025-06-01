<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Invitation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class InvitationRespond extends Component
{
    public $invitationId;
    public $invitation;
    public $event;

    public function mount($invitation)
    {
        $this->invitationId = $invitation;

        $this->invitation = Invitation::with('event')->findOrFail($this->invitationId);

        if ($this->invitation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access.');
        }

        $this->event = $this->invitation->event;
    }

    protected $rules = [
        'invitation.status' => 'required|in:accepted,rejected',
    ];

    public function respond($status)
    {
        if (!in_array($status, ['accepted', 'rejected'])) {
            throw ValidationException::withMessages(['status' => 'Invalid response.']);
        }

        if ($this->invitation->status !== 'pending') {
            session()->flash('message', 'You have already responded to this invitation.');
            return;
        }

        $this->invitation->status = $status;
        $this->invitation->save();

        session()->flash('message', 'Your response has been recorded.');

        return redirect()->route('events.detail', $this->event->id);
    }

    public function render()
    {
        return view('livewire.invitation-respond')->layout('layouts.app');
    }
}
