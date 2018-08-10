<?php

namespace App\Controller\User;

use App\Customer\CustomerManager;
use App\Entity\Customer;

/**
 * Class CustomerSpecial
 * @package App\Controller\User
 */
class CustomerRegister
{
    /**
     * @var CustomerManager
     */
    private $customerManager;

    /**
     * CustomerSpecial constructor.
     * @param CustomerManager $customerManager
     */
    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    /**
     * @param Customer $data
     * @return Customer
     * @throws \Exception
     */
    public function __invoke(Customer $data): Customer
    {
        $this->customerManager->register($data);

        return $data;
    }
}
