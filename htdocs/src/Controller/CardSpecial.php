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
        # TODO : Finir ce controller + test unitaire + gestion des exceptions
        # Génère le nouveau code de la carte de fidélité
        $codeEstablishment = $data->getEstablishment()->getCodeEstablishment();
        $codeCard = $this->cm->generateCardCode($codeEstablishment);

        return $data;
    }
}