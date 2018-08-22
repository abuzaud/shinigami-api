<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserInfos
{
    /**
     * @var TokenStorageInterface
     */
    private $token;
    private $serializer;

    public function __construct(TokenStorageInterface $token, SerializerInterface $serializer)
    {
        $this->token = $token;
        $this->serializer = $serializer;
    }

    public function __invoke()
    {
        $user = $this->token->getToken()->getUser();

        dump($user);
        $jsonUser = $this->serializer->serialize($user, 'json');

        dump($jsonUser);
        $response = new JsonResponse($jsonUser);

        dump($response);
        return $response->sendContent();
    }
}
