<?php

namespace App\Entity;

use App\Repository\HeroLvlRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HeroLvlRepository::class)
 */
class HeroLvl
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
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $xpNeeded;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $itemTier;

    public function getId(): ?int { return $this->id; }

    public function getLvl(): ?int { return $this->lvl; }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;
        return $this;
    }

    public function getXpNeeded(): ?int { return $this->xpNeeded; }

    public function setXpNeeded(int $xpNeeded): self
    {
        $this->xpNeeded = $xpNeeded;
        return $this;
    }

    public function getItemTier(): ?int { return $this->itemTier; }

    public function setItemTier(int $itemTier): self
    {
        $this->itemTier = $itemTier;
        return $this;
    }
}
