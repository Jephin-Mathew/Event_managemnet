<?php

namespace App\Policies;

use App\Models\RequisitionItem;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RequisitionItemPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, RequisitionItem $requisitionItem): bool
    {
         $event = $item->event;
                 if ($item->visibility === 'public') {
            return true;
        }
        return $event->invitations()->where('user_id', $user->id)->exists()
            || $event->creator_id === $user->id
            || $event->event_for === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        $event = $item->event;

        if ($event->creator_id === $user->id && $event->event_for === $user->id) {
            return true;
        }

        return $user->id === $event->creator_id || $user->id === $event->event_for;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, RequisitionItem $requisitionItem): bool
    {
        $event = $item->event;

        $isInvitedAndAccepted = $event->invitations()
            ->where('user_id', $user->id)
            ->where('status', 'accepted')
            ->exists();

        if (!$isInvitedAndAccepted) {
            return false;
        }

        if ($item->claimed_by && !($item->is_gift || $item->is_optional)) {
            return false;
        }

        if ($event->date < now()->toDateString()) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, RequisitionItem $requisitionItem): bool
    {
        $event = $item->event;
        return $user->id === $event->creator_id || $user->id === $event->event_for;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, RequisitionItem $requisitionItem): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, RequisitionItem $requisitionItem): bool
    {
        return false;
    }
}
