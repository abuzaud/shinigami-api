<?php

namespace App\ResetPassword;

/**
 * Class GetResetPasswordQuery
 * @package App\ResetPasswordRequest
 */
class GetResetPasswordQuery
{
    /** @var string */
    private $email;

    /**
     * GetResetPasswordQuery constructor.
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }
}
