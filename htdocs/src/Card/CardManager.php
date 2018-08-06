<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018
 */

namespace App\Card;


use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class CardManager
 * @package App\Card
 */
class CardManager
{
    private $em;

    /**
     * CardManager constructor.
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
    public function checkIfClientCodeExist(string $code): bool
    {
        if (strlen($code) === 6) {
            $card = $this->em->getRepository(Card::class)
                ->findBy([
                    'codeClient' => $code
                ]);

            if (!empty($card)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Génère automatiquement un code client unique
     */
    public function generateClientCode()
    {
        $code = [];

        for ($i = 0; $i < 6; $i++) {
            $code[] = rand(0, 9);
        }

        # On vérifie si le code existe en base
        if(!$this->checkIfClientCodeExist(implode($code))){
            return implode($code);
        } else {
            $this->generateClientCode();
        }
    }
}