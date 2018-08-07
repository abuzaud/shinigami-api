<?php

namespace App\Controller\Card;

use App\Card\CardFactory;
use App\Entity\Card;

class CardSpecial
{
    private $cf;

    public function __construct(CardFactory $cardFactory)
    {
        $this->cf = $cardFactory;
    }

    public function __invoke(Card $data): Card
    {
        /** @var Card $data */
        # TODO : Finir ce controller + test unitaire + gestion des exceptions
        # Génère le nouveau code de la carte de fidélité

        $codeEstablishment = $data->getEstablishmentCode();

        $data = $this->cf->createCard($codeEstablishment);

        return $data;
    }
}