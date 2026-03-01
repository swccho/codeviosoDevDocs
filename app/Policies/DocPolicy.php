<?php

namespace App\Policies;

use App\Models\Doc;
use App\Models\User;

class DocPolicy
{
    /**
     * Ensure the user owns the document.
     */
    public function update(User $user, Doc $doc): bool
    {
        return $doc->user_id === $user->id;
    }

    public function delete(User $user, Doc $doc): bool
    {
        return $doc->user_id === $user->id;
    }

    public function publish(User $user, Doc $doc): bool
    {
        return $doc->user_id === $user->id;
    }

    public function unpublish(User $user, Doc $doc): bool
    {
        return $doc->user_id === $user->id;
    }
}
