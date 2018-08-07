<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018.
 */

namespace App\Card;

use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CardManager.
 */
class CardManager
{
    private $em;

    /**
     * CardManager constructor.
     *
     * @param $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * Retourne vrai si une carte correspondant au code client existe en base.
     * @param string $code
     * @return bool
     */
    public function checkIfCustomerCodeExist(string $code): bool
    {
        if (6 === strlen($code)) {
            $card = $this->em->getRepository(Card::class)
                ->findBy([
                    'codeCustomer' => $code,
                ]);
            if (!empty($card)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Génère automatiquement un code customer unique.
     */
    public function generateCustomerCode()
    {
        $code = [];

        for ($i = 0; $i < 6; ++$i) {
            $code[] = rand(0, 9);
        }

        // On vérifie si le code existe en base
        if (!$this->checkIfCustomerCodeExist(implode($code))) {
            return implode($code);
        } else {
            $this->generateCustomerCode();
        }

        return false;
    }

    /**
     * Vérifie que l'établissement existe bien en base de données
     */
    public function checkIfEstablishmentExist()
    {

    }

    /**
     * Génère un nouveau code unique pour l'établissement
     */
    public function generateEstablishmentCode()
    {

    }


    /**
     * Génère le checksum de la carte
     */
    public function generateChecksum()
    {
    }


    /**
     * Génère le code entier de la carte
     */
    public function generateCardCode()
    {

    }
}
