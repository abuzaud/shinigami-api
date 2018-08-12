<?php
/**
 * Created by PhpStorm.
 * User: Antoine
 * Date: 12/08/2018
 * Time: 19:00
 */

namespace App\Controller\Card;


use App\Card\CardManager;
use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class CardGeneratePdf
{
    private $cm;
    private $em;

    /**
     * CardView constructor.
     * @param CardManager $cardManager
     * @param EntityManagerInterface $entityManager
     * @param BinaryFileResponse $fileResponse
     */
    public function __construct(CardManager $cardManager, EntityManagerInterface $entityManager)
    {
        $this->cm = $cardManager;
        $this->em = $entityManager;
    }

    /**
     * Génère une carte image à partir de l'id de la carte
     * @param $id
     * @return BinaryFileResponse
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __invoke($id)
    {
        $cardDb = $this->em->getRepository(Card::class)->find($id);
        $file = $this->cm->generateCardPdf($cardDb);

        return (new BinaryFileResponse($file))->sendContent();
    }
}