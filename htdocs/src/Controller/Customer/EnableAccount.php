<?php

namespace App\Controller\Customer;

use App\Customer\CustomerManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class EnableAccount
 * @package App\Controller\Customer
 */
class EnableAccount
{
    /**
     * @var CustomerManager
     */
    private $customerManager;

    /**
     * EnableAccount constructor.
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
    public function __invoke(Request $request): JsonResponse
    {
        $email = $request->get('email');
        $token = $request->get('token');

        $this->customerManager->enableAccount($email, $token);

        return new JsonResponse(null, 200);
    }
}
