<?php
/**
 * Created by Antoine Buzaud.
 * Date: 07/08/2018
 */

namespace App\Card;


use App\Entity\Card;
use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CardFactory
 * @package App\Card
 */
class CardFactory
{
    private $cm;
    private $em;

    /**
     * CardFactory constructor.
     * @param CardManager $cardManager
     */
    public function __construct(CardManager $cardManager, EntityManagerInterface $entityManager)
    {
        $this->cm = $cardManager;
        $this->em = $entityManager;
    }

    /**
     * Créé un objet Carte
     * Prend en paramètre un code d'établissement
     * @param $codeEstablishment
     * @return Card|false
     * @throws \Exception
     */
    public function createCard($codeEstablishment)
    {
        # On vérifie que l'établissement existe bien
        if(!$this->cm->checkIfEstablishmentCodeExist($codeEstablishment)){
            return false;
        }

        # On créé l'entité
        $card = new Card();

        # On récupère l'établissement
        $establishment = $this->em->getRepository(Establishment::class)
            ->findOneBy([
               'codeEstablishment' => $codeEstablishment
            ]);
        $card->setEstablishment($establishment);

        # On génère les codes de la carte
        $card->setCodeCard($this->cm->generateCardCode($codeEstablishment));
        $card->setCodeCustomer(substr($card->getCodeCard(), 3, 6));

        return $card;
    }
}