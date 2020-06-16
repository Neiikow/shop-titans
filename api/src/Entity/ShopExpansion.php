<?php

namespace App\Entity;

use App\Repository\ShopExpansionRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ShopExpansionRepository::class)
 */
class ShopExpansion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $tier;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $size;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $furnitureIncrease;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $prerequisite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $constructTime;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $goldCost;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $gemCost;

    public function getId(): ?int { return $this->id; }

    public function getTier(): ?int { return $this->tier; }

    public function setTier(int $tier): self
    {
        $this->tier = $tier;
        return $this;
    }

    public function getSize(): ?int { return $this->size; }

    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function getFurnitureIncrease(): ?int { return $this->furnitureIncrease; }

    public function setFurnitureIncrease(int $furnitureIncrease): self
    {
        $this->furnitureIncrease = $furnitureIncrease;
        return $this;
    }

    public function getPrerequisite(): ?string { return $this->prerequisite; }

    public function setPrerequisite(?string $prerequisite): self
    {
        $this->prerequisite = $prerequisite;
        return $this;
    }

    public function getConstructTime(): ?int { return $this->constructTime; }

    public function setConstructTime(?int $constructTime): self
    {
        $this->constructTime = $constructTime;
        return $this;
    }

    public function getGoldCost(): ?int { return $this->goldCost; }

    public function setGoldCost(int $goldCost): self
    {
        $this->goldCost = $goldCost;
        return $this;
    }

    public function getGemCost(): ?int { return $this->gemCost; }

    public function setGemCost(int $gemCost): self
    {
        $this->gemCost = $gemCost;
        return $this;
    }
}
