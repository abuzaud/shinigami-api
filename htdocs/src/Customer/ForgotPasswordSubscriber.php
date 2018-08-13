<?php

namespace App\Customer;

use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class ForgotPasswordSubscriber
 * @package App\Customer
 */
final class ForgotPasswordSubscriber implements EventSubscriberInterface
{
    /**
     * @var CustomerManager
     */
    private $customerManager;

    /**
     * ForgotPasswordSubscriber constructor.
     * @param CustomerManager $customerManager
     */
    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['forgotPasswordPostValidate', EventPriorities::POST_VALIDATE],
        ];
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     * @throws \Exception
     */
    public function forgotPasswordPostValidate(GetResponseForControllerResultEvent $event): void
    {
        $request = $event->getRequest();

        if ('api_forgot_password_requests_post_collection' !== $request->attributes->get('_route')) {
            return;
        }

        $forgotPasswordRequest = $event->getControllerResult();

        $this->customerManager->forgotPassword($forgotPasswordRequest->email);

        $event->setResponse(new JsonResponse(null, 200));
    }
}
