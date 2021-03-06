<?php

namespace App\Controller\Card;

use App\Card\CardFactory;
use App\Entity\Card;

/**
 * Class CardCreate
 * @package App\Controller\Card
 * @codeCoverageIgnore
 */
class CardCreate
{
    private $cf;

    /**
     * CardCreate constructor.
     * @param CardFactory $cardFactory
     */
    public function __construct(CardFactory $cardFactory)
    {
        $this->cf = $cardFactory;
    }

    /**
     * Créer une carte à partir du code de l'établissement
     * @param Card $data
     * @return Card
     */
    public function __invoke(Card $data): Card
    {
        # Récupération du code de l'établissement
        $establishment = $data->getEstablishment();

        # Création de la carte à partir du code de l'établissement
        try {
            $data = $this->cf->createCardFromEstablishment($establishment);
        } catch (\Exception $e) {
            echo "Une exception a été levé dans le fichier [".$e->getFile()."][ligne : ".$e->getLine()."].".PHP_EOL;
            echo $e->getMessage().PHP_EOL.$e->getCode().PHP_EOL;
        }

        return $data;
    }
}