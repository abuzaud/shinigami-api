<?php

namespace App\ResetPassword;

use App\Dto\ResetPasswordRequest;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ResetPasswordWriteSubscriber
 * @package App\ResetPasswordRequest
 */
class ResetPasswordWriteSubscriber implements EventSubscriberInterface
{
    /**
     * @var UpdateResetPasswordHandler
     */
    private $updateHandler;


    /**
     * ResetPasswordWriteSubscriber constructor.
     * @param UpdateResetPasswordHandler $updateHandler
     */
    public function __construct(UpdateResetPasswordHandler $updateHandler)
    {
        $this->updateHandler = $updateHandler;
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::VIEW => ['write', EventPriorities::PRE_WRITE],
        ];
    }

    /**
     * @param GetResponseForControllerResultEvent $event
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function write(GetResponseForControllerResultEvent $event): void
    {
        $method = $event->getRequest()->getMethod();
        $dto = $event->getControllerResult();

        if (!$dto instanceof ResetPasswordRequest || Request::METHOD_POST !== $method) {
            return;
        }

        $command = new UpdateResetPassword(
            $dto->getEmail(),
            $dto->getPassword(),
            $dto->getToken()
        );

        $this->updateHandler->handle($command);
    }
}
