<?php
/**
 * Created by Antoine Buzaud.
 * Date: 08/08/2018
 */

namespace App\Card;


use App\Entity\Card;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Image;
use Knp\Snappy\Pdf;

/**
 * Class CardPdf
 * @package App\Card
 */
class CardPdf
{
    private $em;
    private $pdfGenerator;
    private $imageGenerator;
    private $twig;

    public function __construct(
        EntityManagerInterface $entityManager,
        Pdf $pdfGenerator,
        Image $imageGenerator,
        \Twig_Environment $twig
    )
    {
        $this->em = $entityManager;
        $this->twig = $twig;

        $this->pdfGenerator = $pdfGenerator;
        $this->pdfGenerator->setOption('no-background', true);
        $this->imageGenerator = $imageGenerator;
    }


    /**
     * Permet de générer un pdf depuis une entité card
     * @param Card $card
     * @param array $datas
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function generateLoyaltyCardFromEntity(Card $card, $datas = [])
    {
        $html = $this->renderCardHTML($card, $datas);

        $outputPdf = '../public/pdf/cards/' . strval($card->getCodeCard() . '_' . time()) . '.pdf';

        $optionsPdf = [
            'lowquality' => false,
            'page-size' => 'A4',
            'viewport-size' => '2480x3508',
            'dpi' => 300,
            'enable-javascript' => true,
            'images' => true,
            'print-media-type' => true,
            'encoding' => 'UTF-8',
            'javascript-delay' => 10000,
            'no-stop-slow-scripts' => true,
            'background' => true,
        ];

        /*
        # Configuration de la génération d'image
        $outputImage = '../var/pdf/' . strval($card->getCodeCard() . '_' . time()) . '.jpeg';
        $optionsImage = [
            'format' => 'jpeg',
            'enable-javascript' => true,
        ];
        $this->generateImage($html, $outputImage, $optionsImage);
        */

        $this->generatePdf($html, $outputPdf, $optionsPdf);
    }

    /**
     * Génère un fichier PDF depuis du html
     * @param $html
     * @param $output
     * @param $options
     */
    public function generatePdf($html, $output, $options)
    {
        $this->pdfGenerator->generateFromHtml($html, $output, $options, true);
    }


    /**
     * Génère un fichier jpeg depuis du html
     * @param $html
     * @param $output
     * @param $options
     */
    public function generateImage($html, $output, $options){
        $this->imageGenerator->generateFromHtml($html, $output, $options, true);
    }

    /**
     * @param Card $card
     * @param $data
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function renderCardHTML(Card $card, $datas = [])
    {
        return $this->twig->render('pdf/card.html.twig', [
            'card' => $card,
            'datas' => $datas
        ]);
    }
}