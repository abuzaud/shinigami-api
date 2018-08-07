<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class ForgotPasswordController
 * @package App\Controller
 */
class ForgotPasswordController extends AbstractController
{
    public function resetPassword($email)
    {
        // email
    }

    public function checkToken($token)
    {

    }

    public function updatePassword($token, $password)
    {
        // $user->setPassword($password);
    }
}