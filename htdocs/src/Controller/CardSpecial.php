<?php

namespace App\Controller;

use App\Entity\Card;

class CardSpecial
{
    //private $myService;

    public function __construct()
    {
        //$this->myService = $myService;
    }

    public function __invoke(Card $data)
    {
        //$this->myService->doSomething($data);

        return $data;
    }
}