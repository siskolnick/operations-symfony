<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * OperationResult
 *
 * @ORM\Table(name="operation_result", indexes={@ORM\Index(name="typeid_idx", columns={"type_id"})})
 * @ORM\Entity(repositoryClass="App\Repository\OperationResultRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type_id", type="integer")
 * @ORM\DiscriminatorMap({1 = "OperationSum", 2 = "OperationProduct", 3 = "OperationPower"})
 */
abstract class OperationResult
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="smallint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="operator1", type="integer", nullable=false)
     * @Assert\NotBlank
     * @Assert\Positive 
     */
    protected $operator1;

    /**
     * @var int|null
     *
     * @ORM\Column(name="operator2", type="integer", nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank
     * @Assert\Positive
     */
    protected $operator2 = NULL;
    
    protected $typeId = 1;
    /**
     * @var int
     *
     */
    protected $result = 0;

    public abstract function getResult();

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOperator1(): ?int
    {
        return $this->operator1;
    }

    public function setOperator1(int $operator1): self
    {
        $this->operator1 = $operator1;

        return $this;
    }

    public function getOperator2(): ?int
    {
        return $this->operator2;
    }

    public function setOperator2(?int $operator2): self
    {
        $this->operator2 = $operator2;

        return $this;
    }

    public function getTypeId(): ?int
    {
        //$this->typeId = $this->type_id;
        return $this->typeId;
    }

    public function setTypeId(int $type): self
    {
        $this->type_id = $type;
        return $this;
    }
}
