<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Serializer\Encoder\JsonEncode;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UserInfos
{
    /**
     * @var TokenStorageInterface
     */
    private $token;
    private $encoder;
    private $normalizer;
    private $serializer;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function __invoke()
    {
        $this->encoder = new JsonEncode();
        $this->normalizer = new ObjectNormalizer();
        $this->serializer = new Serializer($this->normalizer, $this->encoder);

        $user = $this->token->getToken()->getUser();
        $jsonUser = $this->serializer->serialize($user, 'json');

        $response = new JsonResponse($jsonUser);
        return $response->sendContent();
    }
}
