<?php

namespace App\Controller;

use App\Entity\Customer;

class CustomerSpecial
{
    //private $myService;

    public function __construct()
    {
        //$this->myService = $myService;
    }

    public function __invoke(Customer $data)
    {
        //$this->myService->doSomething($data);

        return $data;
    }
}