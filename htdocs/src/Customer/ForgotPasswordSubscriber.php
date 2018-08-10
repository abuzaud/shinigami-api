<?php

namespace App\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Service\MailService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class CustomerSubscriber
 * @package App\Customer
 */
class ForgotPasswordSubscriber implements EventSubscriberInterface
{
    /**
     * @var CustomerManager
     */
    private $customerManager;

    /**
     * @var MailService
     */
    private $mailService;

    /**
     * CustomerSubscriber constructor.
     * @param CustomerManager $customerManager
     * @param MailService $mailService
     */
    public function __construct(CustomerManager $customerManager, MailService $mailService)
    {
        $this->customerManager = $customerManager;
        $this->mailService = $mailService;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['read', EventPriorities::POST_READ],
        ];
    }

    /**
     * @param GetResponseEvent $event
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function read(GetResponseEvent $event): void
    {
        $request = $event->getRequest();

        if ('api_customers_forgot_password_request' !== $request->attributes->get('_route')) {
            return;
        }

        $customer = $this->customerManager->findCustomerByEmail($event->getRequest()->get('email'));

        if ($customer) {
            $subject = 'Réinitialiser votre mot de passe';
            $email = $customer->getEmail();
            $template = 'password-forgot.html.twig';
            $templateData = [
                'token' => $customer->getToken(),
                'email' => $email,
            ];
            $this->mailService->send($subject, $email, $template, $templateData);
        }

        $event->setResponse(new JsonResponse(null, 204));
    }
}
