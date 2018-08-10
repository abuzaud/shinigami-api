<?php

namespace App\Controller\User;

use App\Customer\CustomerManager;
use App\Dto\ResetPasswordRequest;
use App\Entity\Customer;

class ResetPassword
{
    private $customerManager;

    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    public function __invoke(ResetPasswordRequest $data)
    {
        $customer = $this->customerManager->findCustomerByEmailAndToken(
            $data->getEmail(), $data->getToken()
        );
        if ($customer) {
            $customer->setPassword($data->getPassword());
        }
        $data = $customer;
        return $data;

    }


}