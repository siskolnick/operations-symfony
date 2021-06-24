<?php

namespace App\Entity;
use App\Entity\OperationResult;
use Doctrine\ORM\Mapping as ORM;
/**
 * OperationSum
 * 
 * @ORM\Entity
 */
class OperationSum extends OperationResult
{
    /**
     * @var int
     *
     */
    protected $typeId = 1;

    public function getResult(): int
    {
        return $this->operator1 + $this->operator2;
    }
}
