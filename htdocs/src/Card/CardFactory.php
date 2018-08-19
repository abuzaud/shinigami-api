<?php
/**
 * Created by Antoine Buzaud.
 * Date: 07/08/2018
 */

namespace App\Card;


use App\Entity\Card;
use App\Entity\Establishment;
use App\Exception\CardException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Registry;

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
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(CardManager $cardManager, EntityManagerInterface $entityManager)
    {
        $this->cm = $cardManager;
        $this->em = $entityManager;
    }

    /**
     * Créé une carte de fidélité depuis un code d'établissement
     * Prend en paramètre un code d'établissement
     * @param Establishment $establishment
     * @return Card|false
     * @throws \Exception
     */
    public function createCardFromEstablishment(Establishment $establishment)
    {
        # On vérifie que l'établissement existe bien
        if (!$this->cm->checkIfEstablishmentCodeExist($establishment->getCodeEstablishment())) {
            throw new CardException("L'établissement n'existe pas");
            return false;
        }

        # On créé l'entité
        $card = new Card();

        # On génère le code de la carte
        $card = $this->cm->setCardCode($card, $establishment);

        return $card;
    }

    /**
     * Copie de la méthode précédente mais sans les vérif en base pour l'ajout des fixtures
     * @param Establishment $establishment
     * @return Card|bool
     * @throws \Exception
     */
    public function createFixtureCardFromEstablishment(Establishment $establishment)
    {
        $card = new Card();

        $card = $this->cm->setCardCode($card, $establishment);

        return $card;
    }

    /**
     * Créé une entité Card
     * @return Card
     */
    public function createCard()
    {
        return new Card();
    }
}