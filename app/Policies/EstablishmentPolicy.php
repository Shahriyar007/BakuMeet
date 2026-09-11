<?php

namespace App\Policies;

use App\Models\BusinessAccount;
use App\Models\Establishment;

class EstablishmentPolicy
{
    /**
     * Determine whether the business account can view the establishment.
     */
    public function view(BusinessAccount $account, Establishment $establishment): bool
    {
        return $account->establishment_id === $establishment->id;
    }

    /**
     * Determine whether the business account can create an establishment.
     * Only allowed if they don't already have one (1 account = 1 establishment).
     */
    public function create(BusinessAccount $account): bool
    {
        return $account->isApproved() && is_null($account->establishment_id);
    }

    /**
     * Determine whether the business account can update the establishment.
     */
    public function update(BusinessAccount $account, Establishment $establishment): bool
    {
        return $account->establishment_id === $establishment->id;
    }

    /**
     * Determine whether the business account can delete the establishment.
     */
    public function delete(BusinessAccount $account, Establishment $establishment): bool
    {
        return $account->establishment_id === $establishment->id;
    }
}
