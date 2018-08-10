<?php

namespace App\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Customer;
use App\Service\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class EnableAccountSubscriber
 * @package App\Customer
 */
class EnableAccountSubscriber implements EventSubscriberInterface
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
            KernelEvents::VIEW => ['write', EventPriorities::POST_WRITE],
        ];
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function write(GetResponseForControllerResultEvent $event): void
    {
        $method = $event->getRequest()->getMethod();
        $customer = $event->getControllerResult();

        if (!$customer instanceof Customer || Request::METHOD_POST !== $method) {
            return;
        }

        $subject = 'Confirmer votre inscription';
        $email = $customer->getEmail();
        $template = 'account-to-enable.html.twig';
        $templateData = [
            'token' => $customer->getToken(),
            'email' => $email,
        ];
        $this->mailService->send($subject, $email, $template, $templateData);
    }
}
