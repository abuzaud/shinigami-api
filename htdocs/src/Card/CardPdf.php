<?php
/**
 * Created by Antoine Buzaud.
 * Date: 08/08/2018
 */

namespace App\Card;


use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;

/**
 * Class CardPdf
 * @package App\Card
 */
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
        $this->twig = $twig;

        $this->pdfGenerator = $pdfGenerator;
        $this->pdfGenerator->setOption('no-background', true);
    }


    /**
     * Permet de générer un pdf depuis une entité card
     * @param Card $card
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function generateLoyaltyCardFromEntity(Card $card)
    {
        $html = $this->renderCardHTML($card);
        dump($html);

        $output = '../var/pdf/' . strval($card->getCodeCard() . '_' . time()) . '.pdf';

        $options = [
            'lowquality' => false,
            'page-size' => 'A4',
            'viewport-size' => '1024x768',
            'enable-javascript' => true,
            'images' => true,
            'print-media-type' => true,
            'encoding' => 'UTF-8',
            'javascript-delay' => 10000,
            'no-stop-slow-scripts' => true
        ];

        $this->generate($html, $output, $options);

        return $html;
    }


    /**
     * Génère un fichier PDF depuis du html
     * @param $html
     * @param $output
     * @param $options
     */
    public function generate($html, $output, $options)
    {
        $this->pdfGenerator->generateFromHtml($html, $output, $options, true);
    }

    /**
     * @param Card $card
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderCardHTML(Card $card)
    {
        return $this->twig->render('pdf/card.html.twig', [
            'card' => $card
        ]);
    }

}