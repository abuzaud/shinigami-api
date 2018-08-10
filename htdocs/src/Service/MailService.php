<?php

namespace App\Service;

/**
 * Class MailService
 * @package App\Service
 */
class MailService
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * CustomerSubscriber constructor.
     * @param \Swift_Mailer $mailer
     * @param \Twig_Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @param string $subject
     * @param string $email
     * @param string $template
     * @param array $templateData
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function send(string $subject, string $email, string $template, array $templateData = []): void
    {
        $message = (new \Swift_Message($subject))
            ->setFrom('no-reply@shinigami.com')
            ->setTo($email)
            ->setBody(
                $this->twig->render('emails/' . $template, $templateData),
                'text/html'
            );

        $this->mailer->send($message);
    }
}