<?php

namespace App\Controller\Staff;

use App\Staff\StaffManager;
use App\Entity\Staff;

/**
 * Class StaffRegister
 * @package App\Controller\Staff
 * @codeCoverageIgnore
 */
class StaffRegister
{
    /**
     * @var StaffManager
     */
    private $staffManager;

    /**
     * StaffRegister constructor.
     * @param StaffManager $staffManager
     */
    public function __construct(StaffManager $staffManager)
    {
        $this->staffManager = $staffManager;
    }

    /**
     * @param Staff $data
     * @return Staff
     * @throws \Exception
     */
    public function __invoke(Staff $data): Staff
    {
        $this->staffManager->register($data);

        return $data;
    }
}
