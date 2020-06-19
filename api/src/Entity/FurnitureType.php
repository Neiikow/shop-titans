<?php

namespace App\Entity;

use App\Repository\FurnitureTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FurnitureTypeRepository::class)
 */
class FurnitureType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=Furniture::class, mappedBy="type")
     */
    private $furnitures;

    public function __construct()
    {
        $this->furnitures = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getImg(): ?string { return $this->img; }

    public function setImg(string $img): self
    {
        $this->img = $img;
        return $this;
    }

    /**
     * @return Collection|Furniture[]
     */
    public function getFurnitures(): Collection { return $this->furnitures; }

    public function addFurniture(Furniture $furniture): self
    {
        if (!$this->furnitures->contains($furniture)) {
            $this->furnitures[] = $furniture;
            $furniture->setType($this);
        }

        return $this;
    }

    public function removeFurniture(Furniture $furniture): self
    {
        if ($this->furnitures->contains($furniture)) {
            $this->furnitures->removeElement($furniture);

            if ($furniture->getType() === $this) {
                $furniture->setType(null);
            }
        }

        return $this;
    }
}
