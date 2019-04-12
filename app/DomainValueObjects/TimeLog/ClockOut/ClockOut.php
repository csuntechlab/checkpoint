<?php
declare (strict_types = 1);
namespace App\DomainValueObjects\TimeLog\ClockOut;

use App\DomainValueObjects\UUIDGenerator\UUID;
use App\DomainValueObjects\TimeLog\TimePuncher;
use App\DomainValueObjects\TimeLog\ClockOut\Categories;
use App\DomainValueObjects\TimeLog\TimeStamp\TimeStamp;


//Exceptions

class ClockOut extends TimePuncher
{

    private $categories = null;

    public function __construct(UUID $uuid, TimeStamp $timeStamp)
    {
        parent::__construct($uuid, $timeStamp);
        $this->categories = null;
    }

    private function setCategories($categories)
    {
        $this->categories = $categories;
    }

    public static function clockOutWithCategories(UUID $uuid, TimeStamp $timeStamp, Categories $category)
    {
        $instance = new self($uuid, $timeStamp);
        $instance->setCategories($category);
        return $instance;
    }

    public function toArray()
    {
        $data = $this->timeStamp->toArray();
        if ($this->categories != null) {
            $data['categories'] = $this->categories->toArray();
        }
        return $data;
    }
}
