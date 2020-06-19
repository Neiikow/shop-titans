<?php

namespace App\Entity;

use App\Repository\QuestAreaRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestAreaRepository::class)
 */
class QuestArea
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
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $partySize;

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

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $prerequisite;

    /**
     * @ORM\OneToOne(targetEntity=Chest::class, mappedBy="area")
     */
    private $chest;

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

    public function getPartySize(): ?int { return $this->partySize; }

    public function setPartySize(int $partySize): self
    {
        $this->partySize = $partySize;
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

    public function getPrerequisite(): ?string { return $this->prerequisite; }

    public function setPrerequisite(?string $prerequisite): self
    {
        $this->prerequisite = $prerequisite;
        return $this;
    }

    public function getChest(): ?Chest { return $this->chest; }

    public function setChest(?Chest $chest): self
    {
        $this->chest = $chest;

        $newArea = null === $chest ? null : $this;
        if ($chest->getArea() !== $newArea) {
            $chest->setArea($newArea);
        }

        return $this;
    }
}
