<?php

namespace App\ResetPassword;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderInterface;
use ApiPlatform\Core\DataProvider\SerializerAwareDataProviderTrait;
use ApiPlatform\Core\Exception\ResourceClassNotSupportedException;
use App\Dto\ResetPasswordRequest;

/**
 * Class ResetPasswordDataProvider
 * @package App\ResetPasswordRequest
 */
class ResetPasswordDataProvider implements ItemDataProviderInterface, SerializerAwareDataProviderInterface
{
    use SerializerAwareDataProviderTrait;

    /**
     * @var GetResetPasswordQueryHandler
     */
    private $queryHandler;

    /**
     * ResetPasswordDataProvider constructor.
     * @param GetResetPasswordQueryHandler $queryHandler
     */
    public function __construct(GetResetPasswordQueryHandler $queryHandler)
    {
        $this->queryHandler = $queryHandler;
    }

    /**
     * @param string $resourceClass
     * @param string|null $operationName
     * @return bool
     */
    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return ResetPasswordRequest::class === $resourceClass;
    }

    /**
     * @param string $resourceClass
     * @param array|int|string $email
     * @param string|null $operationName
     * @param array $context
     * @return ResetPasswordRequest|null|object
     * @throws ResourceClassNotSupportedException
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function getItem(string $resourceClass, $email, string $operationName = null, array $context = [])
    {
        if (!$this->supports($resourceClass, $operationName)) {
            throw new ResourceClassNotSupportedException();
        }

        $customer = $this->queryHandler->handle(new GetResetPasswordQuery($email));

        $dto = new ResetPasswordRequest();
        $dto->setEmail($customer->getEmail());
        $dto->setPassword($customer->getPassword());
        $dto->setToken($customer->getToken());

        return $dto;
    }
}
