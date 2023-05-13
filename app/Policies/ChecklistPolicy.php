<?php

namespace App\Policies;

use App\User;
use App\Checklist;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChecklistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any checklists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function view(User $user, Checklist $checklist)
    {
        //
    }

    /**
     * Determine whether the user can create checklists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function update(User $user, Checklist $checklist)
    {
        return $user->id === $checklist->created_by;
    }

    /**
     * Determine whether the user can delete the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function delete(User $user, Checklist $checklist)
    {
        return $user->id === $checklist->created_by;
    }

    /**
     * Determine whether the user can restore the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function restore(User $user, Checklist $checklist)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the checklist.
     *
     * @param  \App\User  $user
     * @param  \App\Checklist  $checklist
     * @return mixed
     */
    public function forceDelete(User $user, Checklist $checklist)
    {
        //
    }
}
