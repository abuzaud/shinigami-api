<?php

namespace App\Controller\User;

use App\Customer\CustomerManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RegisterController
 * @package App\Controller\User
 */
class EnableAccount extends AbstractController
{
    /**
     * @var CustomerManager
     */
    private $customerManager;

    /**
     * CustomerSubscriber constructor.
     * @param CustomerManager $customerManager
     */
    public function __construct(CustomerManager $customerManager)
    {
        $this->customerManager = $customerManager;
    }
    
    public function request(Request $request): JsonResponse
    {
        $token = $request->get('token');
        $email = $request->get('email');

        $this->customerManager->enableAccount($email, $token);

        return new JsonResponse(null, 204);
    }
}