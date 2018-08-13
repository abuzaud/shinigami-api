<?php

namespace App\Service;

/**
 * Class UtilsService
 * @package App\Service
 */
class UtilsService
{
    /**
     * Generating a random string
     *
     * @param int $length The initial length of the string knowing that it will be multiplied by 2
     * @return string The string generated
     * @throws \Exception
     */
    public function generateRandomString(int $length): string
    {
        return bin2hex(random_bytes($length));
    }
}
