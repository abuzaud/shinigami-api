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
     * Sending an email
     *
     * @param string $subject The subject
     * @param string|array $senders The sender(s)
     * @param string|array $recipients The recipients(s)
     * @param string $template The template used to send the email
     * @param array $data The data passed in the template
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function send(string $subject, $senders, $recipients, string $template, array $data = []): void
    {
        $message = (new \Swift_Message($subject))
            ->setFrom($senders)
            ->setTo($recipients)
            ->setBody(
                $this->twig->render('emails/' . $template, $data),
                'text/html'
            );

        $this->mailer->send($message);
    }
}
