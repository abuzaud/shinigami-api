<?php
/**
 * Created by Antoine Buzaud.
 * Date: 08/08/2018
 */

namespace App\Card;


use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;

class CardPdf
{

    private $cm;
    private $em;
    private $pdfGenerator;
    private $twig;

    public function __construct(
        CardManager $cardManager,
        EntityManagerInterface $entityManager,
        Pdf $pdfGenerator,
        \Twig_Environment $twig
    )
    {
        $this->cm = $cardManager;
        $this->em = $entityManager;
        $this->pdfGenerator = $pdfGenerator;
        $this->twig = $twig;
    }

    public function generate(Card $card)
    {
        $this->pdfGenerator->generateFromHtml($this->renderTemplate($card), '/pdf/file.pdf');
    }

    public function renderTemplate(Card $card){
        return $this->twig->render('pdf/card.html.twig', [
            'card' => $card
        ]);
    }

}