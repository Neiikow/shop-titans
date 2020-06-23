<?php

namespace App\Entity;

use App\Repository\BuildingLvlRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BuildingLvlRepository::class)
 */
class BuildingLvl
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
    private $lvl;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $tickNeeded;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $effect;

    /**
     * @ORM\ManyToOne(targetEntity=Building::class, inversedBy="lvls")
     * 
     * @JMS\MaxDepth(1)
     */
    private $building;

    public function getId(): ?int { return $this->id; }

    public function getLvl(): ?int { return $this->lvl; }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;
        return $this;
    }

    public function getTickNeeded(): ?int { return $this->tickNeeded; }

    public function setTickNeeded(?int $tickNeeded): self
    {
        $this->tickNeeded = $tickNeeded;
        return $this;
    }

    public function getEffect(): ?string { return $this->effect; }

    public function setEffect(string $effect): self
    {
        $this->effect = $effect;
        return $this;
    }

    public function getBuilding(): ?Building { return $this->building; }

    public function setBuilding(?Building $building): self
    {
        $this->building = $building;
        return $this;
    }
}
