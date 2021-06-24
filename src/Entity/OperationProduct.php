<?php

namespace App\Entity;
use App\Entity\OperationResult;
use Doctrine\ORM\Mapping as ORM;
/**
 * OperationProduct
 *
 * @ORM\Entity
 */
class OperationProduct extends OperationResult
{
    /**
     * @var int
     *
     */
    protected $typeId = 2;

    public function getResult(): int
    {
        return $this->operator1 * 2;
    }
}
