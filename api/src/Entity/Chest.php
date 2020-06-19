<?php

namespace App\Entity;

use App\Repository\ChestRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChestRepository::class)
 */
class Chest
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
    private $openCost;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $goldValue;

    /**
     * @ORM\OneToOne(targetEntity=Consumable::class)
     */
    private $openKey;

    /**
     * @ORM\OneToOne(targetEntity=QuestArea::class, inversedBy="chest")
     */
    private $area;

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

    public function getOpenCost(): ?int { return $this->openCost; }

    public function setOpenCost(int $openCost): self
    {
        $this->openCost = $openCost;
        return $this;
    }

    public function getGoldValue(): ?int { return $this->goldValue; }

    public function setGoldValue(int $goldValue): self
    {
        $this->goldValue = $goldValue;
        return $this;
    }

    public function getOpenKey(): ?Consumable { return $this->openKey; }

    public function setOpenKey(?Consumable $openKey): self
    {
        $this->openKey = $openKey;
        return $this;
    }

    public function getArea(): ?QuestArea { return $this->area; }

    public function setArea(?QuestArea $area): self
    {
        $this->area = $area;
        return $this;
    }
}
