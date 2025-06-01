<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use App\Models\RequisitionItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class RequisitionList extends Component
{
    public $eventId;
    public $event;
    public $items;
    public $newItemName;
    public $newItemDescription;
    public $newItemVisibility = 'private';

    protected $rules = [
        'newItemName' => 'required|string|max:255',
        'newItemDescription' => 'nullable|string',
        'newItemVisibility' => 'required|in:public,private',
    ];

    public function mount($event)
    {
        $this->eventId = $event;
        $this->loadEventAndItems();
    }

    public function loadEventAndItems()
    {
        $userId = Auth::id();

        $this->event = Event::with(['creator', 'eventFor'])
            ->where(function ($query) use ($userId) {
                $query->where('creator_id', $userId)
                      ->orWhere('event_for', $userId)
                      ->orWhereHas('invitations', fn($q) => $q->where('user_id', $userId));
            })
            ->findOrFail($this->eventId);

        $this->items = RequisitionItem::where('event_id', $this->eventId)
            ->where(function ($query) use ($userId) {
                $query->where('visibility', 'public')
                    ->orWhere('visibility', 'private');

            })
            ->orderBy('created_at')
            ->get();
    }

    public function canAddItems()
    {
        $userId = Auth::id();


        if ($this->event->event_for === $this->event->creator_id) {
            return $userId === $this->event->creator_id;
        }

        return $userId === $this->event->creator_id || $userId === $this->event->event_for;
    }

    public function addItem()
    {
        if (!$this->canAddItems()) {
            throw ValidationException::withMessages(['newItemName' => 'You are not authorized to add items.']);
        }

        $this->validate();

        if ($this->event->date < now()->toDateString()) {
            throw ValidationException::withMessages(['newItemName' => 'Event has ended. Cannot add items.']);
        }

        RequisitionItem::create([
            'event_id' => $this->eventId,
            'name' => $this->newItemName,
            'description' => $this->newItemDescription,
            'visibility' => $this->newItemVisibility,
        ]);

        $this->newItemName = '';
        $this->newItemDescription = '';
        $this->newItemVisibility = 'private';

        $this->loadEventAndItems();

        session()->flash('message', 'Item added successfully!');
    }

public function render()
{
    return view('livewire.requisition-list', [
        'canAddItems' => $this->canAddItems()
    ])->layout('layouts.app');
}
}
