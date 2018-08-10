<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class EnableAccountRequest
{
    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    public $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     */
    public $token;
}
