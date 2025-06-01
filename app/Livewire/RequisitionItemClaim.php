<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\RequisitionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RequisitionItemClaim extends Component
{
    public $itemId;
    public $item;

    public function mount($item)
    {
        $this->itemId = $item;
        $this->loadItem();
    }

    public function loadItem()
    {
        $this->item = RequisitionItem::with('event')->findOrFail($this->itemId);
    }

    public function claim()
    {
        $userId = Auth::id();

        $event = $this->item->event;

        $isAcceptedInvitee = $event->invitations()
            ->where('user_id', $userId)
            ->where('status', 'accepted')
            ->exists();

        if (!$isAcceptedInvitee) {
            throw ValidationException::withMessages(['claim' => 'You are not authorized to claim this item.']);
        }


        if ($event->date < now()->toDateString()) {
            throw ValidationException::withMessages(['claim' => 'Event has ended. Claims are closed.']);
        }


        if ($this->item->claimed_by && !($this->item->is_gift || $this->item->is_optional)) {
            throw ValidationException::withMessages(['claim' => 'This item has already been claimed.']);
        }

        $this->item->claimed_by = $userId;
        $this->item->save();

        $this->loadItem();

        session()->flash('message', 'You have successfully claimed this item.');

        $this->dispatch('itemClaimed', $this->itemId);

    }

    public function render()
    {
        return view('livewire.requisition-item-claim')->layout('layouts.app');
    }
}
