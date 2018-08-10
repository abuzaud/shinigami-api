<?php

namespace App\ResetPassword;

/**
 * Class UpdateResetPassword
 * @package App\ResetPasswordRequest
 */
class UpdateResetPassword
{
    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * UpdateResetPassword constructor.
     * @param string $email
     * @param string $password
     * @param string $token
     */
    public function __construct(string $email, string $password, string $token)
    {
        $this->email = $email;
        $this->password = $password;
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }
}
