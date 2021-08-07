<?php

namespace App\Rules;

use App\Models\Room;
use Illuminate\Contracts\Validation\Rule;

class RuleRoomReserve implements Rule
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
        $rsReserve = Room::where('rmNo', $value)->where('rmStatus',  'RS')->exists();
        return !$rsReserve;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The room has been reserved.';
    }
}
