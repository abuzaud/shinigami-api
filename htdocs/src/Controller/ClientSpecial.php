<?php

namespace App\Controller;

use App\Entity\Client;

class ClientSpecial
{
    //private $myService;

    public function __construct()
    {
        //$this->myService = $myService;
    }

    public function __invoke(Client $data)
    {
        //$this->myService->doSomething($data);

        return $data;
    }
}