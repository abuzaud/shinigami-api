<?php
/**
 * Created by Antoine Buzaud.
 * Date: 21/08/2018
 */

namespace App\Controller\Card;


use App\Card\CardManager;
use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;

class Activate
{

    public function __construct(CardManager $cardManager, EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->cm = $cardManager;
    }

    public function __invoke($id)
    {
        $card = $this->em->getRepository(Card::class)->find($id);
        $this->cm->activateCard($card);
        $this->em->flush();

        return $card;
    }
}