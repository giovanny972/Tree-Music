<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Plant::class, mappedBy="category")
     */
    private $Plant;

    public function __construct()
    {
        $this->Plant = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|Plant[]
     */
    public function getPlant(): Collection
    {
        return $this->Plant;
    }

    public function addPlant(Plant $plant): self
    {
        if (!$this->Plant->contains($plant)) {
            $this->Plant[] = $plant;
            $plant->setCategory($this);
        }

        return $this;
    }

    public function removePlant(Plant $plant): self
    {
        if ($this->Plant->removeElement($plant)) {
            // set the owning side to null (unless already changed)
            if ($plant->getCategory() === $this) {
                $plant->setCategory(null);
            }
        }

        return $this;
    }
}
