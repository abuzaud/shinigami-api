<?php

namespace App\Service;

/**
 * Class UtilsService
 * @package App\Service
 */
class UtilsService
{
    /**
     * @param $number
     * @return string
     * @throws \Exception
     */
    public function generateSecureRandomString($number): string
    {
        return md5(random_bytes($number));
    }
}