<?php

namespace App\Entity;

use App\Repository\AccountLvlRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AccountLvlRepository::class)
 */
class AccountLvl
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
    private $gemReward;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $marketTier;

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

    public function getGemReward(): ?int { return $this->gemReward; }

    public function setGemReward(int $gemReward): self
    {
        $this->gemReward = $gemReward;
        return $this;
    }

    public function getMarketTier(): ?int { return $this->marketTier; }

    public function setMarketTier(int $marketTier): self
    {
        $this->marketTier = $marketTier;
        return $this;
    }
}
