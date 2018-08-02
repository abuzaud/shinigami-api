<?php

namespace App\Controller;

use App\Entity\Address;

class AddressSpecial
{
    //private $myService;

    public function __construct()
    {
        //$this->myService = $myService;
    }

    public function __invoke(Address $data)
    {
        //$this->myService->doSomething($data);

        return $data;
    }
}