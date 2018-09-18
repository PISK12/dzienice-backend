<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\StreetRepository")
 */
class Street
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NameInGenitive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ShortName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\District", inversedBy="streets")
     */
    private $Districts;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getNameInGenitive(): ?string
    {
        return $this->NameInGenitive;
    }

    public function setNameInGenitive(string $NameInGenitive): self
    {
        $this->NameInGenitive = $NameInGenitive;

        return $this;
    }

    public function getShortName(): ?string
    {
        return $this->ShortName;
    }

    public function setShortName(string $ShortName): self
    {
        $this->ShortName = $ShortName;

        return $this;
    }

    public function getDistricts(): ?District
    {
        return $this->Districts;
    }

    public function setDistricts(?District $Districts): self
    {
        $this->Districts = $Districts;

        return $this;
    }
}
