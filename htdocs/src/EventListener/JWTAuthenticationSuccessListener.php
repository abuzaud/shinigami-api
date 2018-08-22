<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class JWTAuthenticationSuccessListener
{

    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        //$payload       = $event->getData();
        //$payload['id'] = $user->getId();
        //$payload['email'] = $user->getEmail();

        $data['data'] = [
            'id' => $user->getId()
        ];

        $event->setData($data);
    }
}
