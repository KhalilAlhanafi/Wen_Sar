<?php

namespace App\Policies;

use App\Models\Review;
use App\Models\User;
use App\Models\Business;

class ReviewPolicy
{
    /**
     * Determine whether the user can create a review.
     */
    public function create(User $user, Business $business): bool
    {
        // Cannot review own business
        if ($business->owner_id === $user->id) {
            return false;
        }
        
        // Can only review approved businesses
        if ($business->status !== 'approved') {
            return false;
        }
        
        // Check if user already reviewed this business (one review per user per business)
        $existingReview = Review::where('user_id', $user->id)
            ->where('business_id', $business->id)
            ->first();
            
        if ($existingReview) {
            return false;
        }
        
        return true;
    }

    /**
     * Determine whether the user can update the review.
     */
    public function update(User $user, Review $review): bool
    {
        return $review->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the review.
     */
    public function delete(User $user, Review $review): bool
    {
        // User can delete their own review
        if ($review->user_id === $user->id) {
            return true;
        }
        
        // Business owner can delete reviews on their business
        $business = Business::find($review->business_id);
        if ($business && $business->owner_id === $user->id) {
            return true;
        }
        
        return false;
    }
}
