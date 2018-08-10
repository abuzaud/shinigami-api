<?php

namespace App\Customer;

use App\Service\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CustomerSubscriber
 * @package App\Customer
 */
class CustomerSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailService
     */
    private $mailService;

    /**
     * CustomerSubscriber constructor.
     * @param MailService $mailService
     */
    public function __construct(MailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            CustomerEvents::CUSTOMER_ACCOUNT_ENABLED => ['sendConfirmationAccountEnabled'],
            CustomerEvents::CUSTOMER_RESET_PASSWORD => ['sendConfirmationResetPassword'],
        ];
    }

    /**
     * @param CustomerEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendConfirmationAccountEnabled(CustomerEvent $event): void
    {
        $subject = 'Welcome !';
        $email = $event->getCustomer()->getEmail();
        $template = 'account-enabled.html.twig';
        $this->mailService->send($subject, $email, $template);
    }

    /**
     * @param CustomerEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendConfirmationResetPassword(CustomerEvent $event): void
    {
        $subject = 'Mot de passe initialisé';
        $email = $event->getCustomer()->getEmail();
        $template = 'password-reset.html.twig';
        $this->mailService->send($subject, $email, $template);
    }
}
