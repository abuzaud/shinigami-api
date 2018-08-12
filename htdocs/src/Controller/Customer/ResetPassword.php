<?php

namespace App\Controller\Customer;

use App\Customer\CustomerManager;
use App\Entity\Customer;

/**
 * Class ResetPassword
 * @package App\Controller\Customer
 */
class ResetPassword
{
    /**
     * @var CustomerManager
     */
    private $customerManager;

    /**
     * ResetPassword constructor.
     * @param CustomerManager $customerManager
     */
    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    /**
     * @param Customer $data
     * @return Customer
     */
    public function __invoke(Customer $data): Customer
    {
        $this->customerManager->resetPassword(
            $data->getId(),
            $data->getEmail(),
            $data->getToken(),
            $data->getPassword()
        );

        return $data;
    }
}
