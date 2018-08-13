<?php

namespace App\Customer;

/**
 * Class CustomerEvents
 * @package App\Customer
 */
final class CustomerEvents
{
    public const CUSTOMER_ACCOUNT_TO_ENABLE = 'customer.account_to_enable';
    public const CUSTOMER_ACCOUNT_ENABLED = 'customer.account_enabled';
    public const CUSTOMER_PASSWORD_TO_RESET = 'customer.password_to_reset';
    public const CUSTOMER_PASSWORD_RESET = 'customer.password_reset';
}
