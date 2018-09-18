<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DistrictRepository")
 */
class District
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
     * @ORM\ManyToOne(targetEntity="App\Entity\City", inversedBy="districts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idCity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Street", mappedBy="Districts")
     */
    private $streets;

    public function __construct()
    {
        $this->streets = new ArrayCollection();
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

    public function getIdCity(): ?City
    {
        return $this->idCity;
    }

    public function setIdCity(?City $idCity): self
    {
        $this->idCity = $idCity;

        return $this;
    }

    /**
     * @return Collection|Street[]
     */
    public function getStreets(): Collection
    {
        return $this->streets;
    }

    public function addStreet(Street $street): self
    {
        if (!$this->streets->contains($street)) {
            $this->streets[] = $street;
            $street->setDistricts($this);
        }

        return $this;
    }

    public function removeStreet(Street $street): self
    {
        if ($this->streets->contains($street)) {
            $this->streets->removeElement($street);
            // set the owning side to null (unless already changed)
            if ($street->getDistricts() === $this) {
                $street->setDistricts(null);
            }
        }

        return $this;
    }
}
