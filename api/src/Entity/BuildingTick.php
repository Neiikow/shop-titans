<?php

namespace App\Entity;

use App\Repository\BuildingTickRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=BuildingTickRepository::class)
 */
class BuildingTick
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
    private $tick;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $goldPerTick;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $gemPerTick;

    public function getId(): ?int { return $this->id; }

    public function getTier(): ?int { return $this->tier; }

    public function setTier(int $tier): self
    {
        $this->tier = $tier;
        return $this;
    }

    public function getTick(): ?int { return $this->tick; }

    public function setTick(int $tick): self
    {
        $this->tick = $tick;
        return $this;
    }

    public function getGoldPerTick(): ?int { return $this->goldPerTick; }

    public function setGoldPerTick(int $goldPerTick): self
    {
        $this->goldPerTick = $goldPerTick;
        return $this;
    }

    public function getGemPerTick(): ?int { return $this->gemPerTick; }

    public function setGemPerTick(int $gemPerTick): self
    {
        $this->gemPerTick = $gemPerTick;
        return $this;
    }
}
