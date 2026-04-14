<?php

namespace App\Policies;

use App\Models\Business;
use App\Models\User;

class BusinessPolicy
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
    public function view(?User $user, Business $business): bool
    {
        // Public can only view approved businesses
        if ($business->status === 'approved') {
            return true;
        }
        
        // Owner can view their own businesses regardless of status
        if ($user && $business->owner_id === $user->id) {
            return true;
        }
        
        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('owner');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Business $business): bool
    {
        // Only owner can update their own business
        return $business->owner_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Business $business): bool
    {
        // Only owner can delete their own business
        return $business->owner_id === $user->id;
    }

    /**
     * Determine whether the user can review the business.
     */
    public function review(User $user, Business $business): bool
    {
        // Cannot review own business
        if ($business->owner_id === $user->id) {
            return false;
        }
        
        // Can only review approved businesses
        if ($business->status !== 'approved') {
            return false;
        }
        
        return true;
    }
}
