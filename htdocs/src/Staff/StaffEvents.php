<?php

namespace App\Staff;

/**
 * Class StaffEvents
 * @package App\Staff
 * @codeCoverageIgnore
 */
final class StaffEvents
{
    public const STAFF_PASSWORD_TO_UPDATE = 'staff.password_to_enable';
    public const STAFF_PASSWORD_TO_RESET = 'staff.password_to_reset';
    public const STAFF_PASSWORD_RESET = 'staff.password_reset';
}
