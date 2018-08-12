<?php

namespace App\Staff;

use App\Service\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class StaffSubscriber
 * @package App\Staff
 */
class StaffSubscriber implements EventSubscriberInterface
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
            StaffEvents::STAFF_PASSWORD_TO_UPDATE => ['sendMailPasswordToUpdate'],
        ];
    }

    /**
     * TODO
     *
     * @param StaffEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function sendMailPasswordToUpdate(StaffEvent $event): void
    {
        $staff = $event->getStaff();

        $subject = $this->translator->trans('password_to_update.subject', [], 'emails');
        $senders = 'no-reply@shinigami.com';
        $recipients = $staff->getEmail();
        $template = 'staff/password-to-update.html.twig';
        $data = [
            'email' => $staff->getEmail(),
            'password' => $staff->getPassword(),
        ];

        $this->mailService->send($subject, $senders, $recipients, $template, $data);
    }
}
