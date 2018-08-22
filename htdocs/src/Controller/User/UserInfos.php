<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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

    /**
     * Retourne les informations de l'utilisateur en fonction du token reçu
     * @return Response
     */
    public function __invoke()
    {
        $user = $this->token->getToken()->getUser();
        $jsonUser = $this->serializer->serialize($user, 'json');

        return new Response($jsonUser);
    }
}
