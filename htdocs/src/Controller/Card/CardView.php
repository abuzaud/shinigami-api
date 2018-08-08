<?php
/**
 * Created by Antoine Buzaud.
 * Date: 08/08/2018
 */

namespace App\Controller\Card;


use App\Card\CardFactory;
use App\Entity\Card;

/**
 * Class CardView
 * @package App\Controller\Card
 */
class CardView
{
    private $cf;

    /**
     * CardView constructor.
     * @param CardFactory $cardFactory
     */
    public function __construct(CardFactory $cardFactory)
    {
        $this->cf = $cardFactory;
    }

    /**
     * Génère une carte image à partir de l'id de la carte
     * @param Card $data
     * @return Card
     */
    public function __invoke(Card $data): Card
    {
        // TODO: Implement __invoke() method.
    }
}