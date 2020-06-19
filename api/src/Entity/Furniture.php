<?php

namespace App\Entity;

use App\Repository\FurnitureRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FurnitureRepository::class)
 */
class Furniture
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $img;

    /**
     * @ORM\Column(type="array", nullable=true)
     * 
     * @Assert\Type("array")
     */
    private $goldCosts = [];

    /**
     * @ORM\ManyToOne(targetEntity=FurnitureType::class, inversedBy="furnitures")
     * 
     * @JMS\MaxDepth(1)
     */
    private $type;

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getImg(): ?string { return $this->img; }

    public function setImg(?string $img): self
    {
        $this->img = $img;
        return $this;
    }

    public function getGoldCosts(): ?array { return $this->goldCosts; }

    public function setGoldCosts(?array $goldCosts): self
    {
        $this->goldCosts = $goldCosts;
        return $this;
    }

    public function getType(): ?FurnitureType { return $this->type; }

    public function setType(?FurnitureType $type): self
    {
        $this->type = $type;
        return $this;
    }
}
