<?php

namespace App\Staff;

use App\Entity\Staff;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class StaffEvent
 * @package App\Staff
 */
class StaffEvent extends Event
{
    /**
     * @var Staff
     */
    private $staff;

    /**
     * StaffEvent constructor.
     * @param $staff
     */
    public function __construct(Staff $staff)
    {
        $this->staff = $staff;
    }

    /**
     * @return Staff
     */
    public function getStaff(): Staff
    {
        return $this->staff;
    }
}
