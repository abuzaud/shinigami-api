<?php

namespace App\Customer;

use App\Entity\Customer;
use Symfony\Component\EventDispatcher\Event;

class CustomerEvent extends Event
{
    private $customer;

    /**
     * CustomerEvent constructor.
     * @param $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
