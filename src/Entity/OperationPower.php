<?php

namespace App\Entity;
use App\Entity\OperationResult;
use Doctrine\ORM\Mapping as ORM;
/**
 * OperationPower
 *
 * @ORM\Entity
 */
class OperationPower extends OperationResult
{
    /**
     * @var int
     *
     */
    protected $typeId = 3;

    public function getResult(): int
    {
        return pow($this->operator1,2);
    }
}
