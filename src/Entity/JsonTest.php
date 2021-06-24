<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JsonTest
 *
 * @ORM\Table(name="json_test")
 * @ORM\Entity
 */
class JsonTest
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string|null
     *
     * @ORM\Column(name="test", type="text", length=0, nullable=true, options={"default"="NULL"})
     */
    private $test = 'NULL';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTest(): ?string
    {
        return $this->test;
    }

    public function setTest(?string $test): self
    {
        $this->test = $test;

        return $this;
    }


}
