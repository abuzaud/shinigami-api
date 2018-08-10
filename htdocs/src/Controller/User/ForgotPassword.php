<?php

namespace App\Controller\User;

use App\Customer\CustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ForgotPasswordController
 * @package App\Controller\User
 */
class ForgotPassword extends AbstractController
{
    /**
     * @var CustomerManager
     */
    private $customerManager;

    /**
     * ForgotPassword constructor.
     * @param CustomerManager $customerManager
     */
    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function request(Request $request): JsonResponse
    {
        $email = $request->get('email');

        $this->customerManager->forgotPassword($email);

        return new JsonResponse(null, 204);
    }
}
