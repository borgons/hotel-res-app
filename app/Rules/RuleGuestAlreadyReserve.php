<?php

namespace App\Rules;

use App\Models\Guest;
use Illuminate\Contracts\Validation\Rule;

class RuleGuestAlreadyReserve implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $guestReserved = Guest::where('guestID', $value)->exists();

        return !$guestReserved;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You already reserved this room.';
    }
}
