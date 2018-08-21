<?php

namespace App\Customer;

use App\Service\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class CustomerSubscriber
 * @package App\Customer
 * @codeCoverageIgnore
 */
class CustomerSubscriber implements EventSubscriberInterface
{
    /**
     * @var MailService
     */
    private $mailService;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * CustomerSubscriber constructor.
     * @param MailService $mailService
     * @param TranslatorInterface $translator
     */
    public function __construct(MailService $mailService, TranslatorInterface $translator)
    {
        $this->mailService = $mailService;
        $this->translator = $translator;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            CustomerEvents::CUSTOMER_ACCOUNT_TO_ENABLE => ['sendMailAccountToEnable'],
            CustomerEvents::CUSTOMER_ACCOUNT_ENABLED => ['sendMailAccountEnabled'],
            CustomerEvents::CUSTOMER_PASSWORD_TO_RESET => ['sendMailPasswordToReset'],
            CustomerEvents::CUSTOMER_PASSWORD_RESET => ['sendMailPasswordReset'],
        ];
    }

    /**
     * Sending an email after registration to enable the account
     *
     * @param CustomerEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailAccountToEnable(CustomerEvent $event): void
    {
        $customer = $event->getCustomer();

        $subject = $this->translator->trans('account_to_enable.subject', [], 'emails');
        $senders = 'no-reply@shinigami.com';
        $recipients = $customer->getEmail();
        $template = 'customer/account-to-enable.html.twig';
        $data = [
            'url' => '127.0.0.1:8000',
            'email' => $customer->getEmail(),
            'token' => $customer->getToken(),
        ];

        $this->mailService->send($subject, $senders, $recipients, $template, $data);
    }

    /**
     * Sending an email after enabling the account to confirm that the account is enabled
     *
     * @param CustomerEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailAccountEnabled(CustomerEvent $event): void
    {
        $customer = $event->getCustomer();

        $subject = $this->translator->trans('account_enabled.subject', [], 'emails');
        $senders = 'no-reply@shinigami.com';
        $recipients = $customer->getEmail();
        $template = 'customer/account-enabled.html.twig';

        $this->mailService->send($subject, $senders, $recipients, $template);
    }

    /**
     * Sending an email after clicking on the button "forgotten password"
     *
     * @param CustomerEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailPasswordToReset(CustomerEvent $event): void
    {
        $customer = $event->getCustomer();

        $subject = $this->translator->trans('password_to_reset.subject', [], 'emails');
        $senders = 'no-reply@shinigami.com';
        $recipients = $customer->getEmail();
        $template = 'password-to-reset.html.twig';
        $data = [
            'url' => '127.0.0.1:8000',
            'id' => $customer->getId(),
            'email' => $customer->getEmail(),
            'token' => $customer->getToken(),
        ];

        $this->mailService->send($subject, $senders, $recipients, $template, $data);
    }

    /**
     * Sending an email after resetting the password to confirm that the password is reset
     *
     * @param CustomerEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailPasswordReset(CustomerEvent $event): void
    {
        $customer = $event->getCustomer();

        $subject = $this->translator->trans('password_reset.subject', [], 'emails');
        $senders = 'no-reply@shinigami.com';
        $recipients = $customer->getEmail();
        $template = 'password-reset.html.twig';

        $this->mailService->send($subject, $senders, $recipients, $template);
    }
}
