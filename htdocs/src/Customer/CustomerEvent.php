<?php

namespace App\Customer;

use App\Entity\Customer;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class CustomerEvent
 * @package App\Customer
 */
class CustomerEvent extends Event
{
    /**
     * @var Customer
     */
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
