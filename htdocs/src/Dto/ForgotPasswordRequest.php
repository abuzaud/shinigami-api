<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class ForgotPasswordRequest
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;
}
