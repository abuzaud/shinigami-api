<?php

namespace App\Controller;

use App\Card\CardManager;
use App\Entity\Card;

class CardSpecial
{
    private $cardmanager;

    public function __construct(CardManager $cm)
    {
        $this->cardmanager = $cm;
    }

    public function __invoke(Card $data)
    {

        $this->cardmanager->checkIfClientCodeExist(681507);


        return $data;
    }
}