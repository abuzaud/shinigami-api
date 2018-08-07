<?php

namespace App\Controller;

use App\Card\CardManager;
use App\Entity\Card;

class CardSpecial
{
    private $cm;

    public function __construct(CardManager $cardManager)
    {
        $this->cm = $cardManager;
    }

    public function __invoke(Card $data)
    {
        # Génère le nouveau code de la carte de fidélité

        return $data;
    }
}