<?php
/**
 * Created by Antoine Buzaud.
 * Date: 06/08/2018.
 */

namespace App\Card;

use App\Entity\Card;
use App\Entity\Establishment;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class CardManager.
 */
class CardManager
{
    private $em;
    private $pdf;
    private $router;

    /**
     * CardManager constructor.
     *
     * @param EntityManagerInterface $em
     * @param CardPdf $pdf
     * @param UrlGeneratorInterface $router
     */
    public function __construct(EntityManagerInterface $em, CardPdf $pdf, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->pdf = $pdf;
        $this->router = $router;
    }

    /**
     * Retourne vrai si une carte correspondant au code client existe en base de données.
     * Prends en argument un string
     * @param string $code *
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
     * @throws \Exception
     */
    public function generateCustomerCode(): ?string
    {
        $code = [];

        for ($i = 0; $i < 6; ++$i) {
            $code[] = random_int(0, 9);
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
     * Vérifie que l'établissement existe bien en base de données.
     * Prends en argument un string, retourne un boolean
     */
    public function checkIfEstablishmentCodeExist(string $code): bool
    {
        $establishment = $this->em->getRepository(Establishment::class)
            ->findBy([
                'codeEstablishment' => $code,
            ]);

        if (empty($establishment)) {
            return false;
        }

        return true;
    }

    /**
     * Génère un nouveau code unique pour l'établissement.
     * @throws \Exception
     */
    public function generateEstablishmentCode(): ?string
    {
        $code = [];
        # On génère le code
        for ($i = 0; $i < 3; $i++) {
            $code[] = random_int(0, 9);
        }

        # On vérifie s'il existe en base de données
        if (!$this->checkIfEstablishmentCodeExist(implode($code))) {
            return implode($code);
        } else {
            $this->generateEstablishmentCode();
        }
        return false;
    }

    /**
     * Génère le checksum de la carte.
     * Prends en paramètre un string pour le code de l'établissement et un string pour le code client
     * @param string $codeEstablishment
     * @param string $codeCustomer
     * @return null|string
     */
    public function generateChecksum(string $codeEstablishment, string $codeCustomer): ?string
    {
        if (strlen($codeEstablishment) === 3 && strlen($codeCustomer) === 6) {
            return ((intval($codeEstablishment) + intval($codeCustomer)) % 9);
        }
        return false;
    }

    /**
     * Génère le code entier de la carte.
     * Prends en paramètre le code (string) de l'établissement émettrice
     *
     * @param string $codeEstablishment
     * @return string
     * @throws \Exception
     */
    public function generateCardCode(string $codeEstablishment): ?string
    {
        $codeCustomer = $this->generateCustomerCode();
        $checksum = $this->generateChecksum($codeEstablishment, $codeCustomer);

        return strval($codeEstablishment) . strval($codeCustomer) . strval($checksum);
    }

    /**
     * Génère un fichier PDF de la carte de fidélité
     * @param Card $card
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function generateCardPdf(Card $card)
    {
        $datas['checksum'] = substr($card->getCodeCard(),-1);
        $datas['address'] = $card->getEstablishment()->getAddress();
        $datas['qrcode'] = '/api/customers/'.$card->getCustomer()->getId();
        $datas['qrcode'] = $this->router->generate(
            'api_customers_get_item',
            array('id' => $card->getCustomer()->getId())
        );

        $file = $this->pdf->generateLoyaltyCardFromEntity($card, $datas);

        return $file;
    }
}
