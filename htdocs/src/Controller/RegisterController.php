<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class RegisterController
 * @package App\Controller
 */
class RegisterController extends AbstractController
{
    public function confirmRegister($token, $email)
    {
        // $user->isActive(true);
    }
}