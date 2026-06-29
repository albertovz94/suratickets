<?php

namespace App\Policies;

use App\Models\EquipmentRequest;
use App\Models\User;

class EquipmentRequestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true; // Everyone authenticated can view requests list (query will filter properly)
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EquipmentRequest $request): bool
    {
        return $user->hasAdminAccess() || $user->id === $request->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can request equipment
    }

    /**
     * Determine whether the user can update the model (approve, reject, deliver).
     */
    public function update(User $user, EquipmentRequest $request): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EquipmentRequest $request): bool
    {
        return $user->hasAdminAccess();
    }

    /**
     * Determine whether the user can comment on the request.
     */
    public function comment(User $user, EquipmentRequest $request): bool
    {
        if ($user->hasAdminAccess()) {
            return true;
        }

        // For regular users, they can only comment if they own the request AND:
        // Either 15 days have passed since creation OR there are already comments in the thread.
        if ($user->id !== $request->user_id) {
            return false;
        }

        $daysSinceCreation = $request->created_at->diffInDays(now());
        $hasComments = $request->comments()->exists();

        return $daysSinceCreation >= 15 || $hasComments;
    }
}
