<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\ManyToMany(targetEntity="App\Entity\District", inversedBy="streets")
     */
    private $Districts;

    public function __construct()
    {
        $this->Districts = new ArrayCollection();
    }

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

    /**
     * @return Collection|District[]
     */
    public function getDistricts(): Collection
    {
        return $this->Districts;
    }

    public function addDistrict(District $district): self
    {
        if (!$this->Districts->contains($district)) {
            $this->Districts[] = $district;
        }

        return $this;
    }

    public function removeDistrict(District $district): self
    {
        if ($this->Districts->contains($district)) {
            $this->Districts->removeElement($district);
        }

        return $this;
    }
}
