<?php
/**
 * Created by Antoine Buzaud.
 * Date: 17/08/2018
 */

namespace App\Controller\Card;


use App\Card\CardFactory;
use App\Card\CardManager;
use App\Entity\Card;
use App\Exception\CardException;
use Doctrine\ORM\EntityManagerInterface;

class AddCustomer
{
    private $cf;
    private $em;
    private $cm;

    public function __construct(CardFactory $cardFactory, CardManager $cardManager, EntityManagerInterface $entityManager)
    {
        $this->cf = $cardFactory;
        $this->em = $entityManager;
        $this->cm = $cardManager;
    }

    public function __invoke(Card $data)
    {
        if(empty($data->getEstablishment()) || empty($data->getCustomer())){
            throw new CardException("Veuillez fournir les informations suivantes : 'establishment', 'customer'");

            return $data;
        }

        if (!empty($data->getCodeCard())) {
            // On cherche la carte dont le code est renseigné
            $card = $this->em->getRepository(Card::class)->findOneBy([
                'codeCard' => $data->getCodeCard(),
                'establishment' => $data->getEstablishment()
            ]);
        } else {
            // On recherche une carte non activé et on l'attribut au client
            $card = $this->em->getRepository(Card::class)->findOneBy([
                'customer' => null,
                'establishment' => $data->getEstablishment()
            ]);
        }

        // Sinon on créé une nouvelle carte
        if(empty($card)){
            $card = $this->cf->createCardFromEstablishment($data->getEstablishment());
            $this->em->persist($card);
        }

        # On attribut la carte au client
        $this->cm->setCardCustomer($card, $data->getCustomer());

        return $card;
    }
}