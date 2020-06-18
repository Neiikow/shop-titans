<?php

namespace App\Entity;

use App\Repository\GuildUpgradeRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GuildUpgradeRepository::class)
 */
class GuildUpgrade
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
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $prerequisite;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $renowmCost;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $effect;

    /**
     * @ORM\ManyToOne(targetEntity=GuildPerk::class, inversedBy="upgrades")
     * 
     * @JMS\MaxDepth(1)
     */
    private $perk;

    /**
     * @ORM\ManyToOne(targetEntity=GuildBoost::class, inversedBy="upgrades")
     * 
     * @JMS\MaxDepth(1)
     */
    private $boost;

    public function getId(): ?int { return $this->id; }

    public function getLvl(): ?int { return $this->lvl; }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;
        return $this;
    }

    public function getPrerequisite(): ?string { return $this->prerequisite; }

    public function setPrerequisite(string $prerequisite): self
    {
        $this->prerequisite = $prerequisite;
        return $this;
    }

    public function getRenowmCost(): ?int { return $this->renowmCost; }

    public function setRenowmCost(int $renowmCost): self
    {
        $this->renowmCost = $renowmCost;
        return $this;
    }

    public function getEffect(): ?string { return $this->effect; }

    public function setEffect(?string $effect): self
    {
        $this->effect = $effect;
        return $this;
    }

    public function getPerk(): ?GuildPerk { return $this->perk; }

    public function setPerk(?GuildPerk $perk): self
    {
        $this->perk = $perk;
        return $this;
    }

    public function getBoost(): ?GuildBoost { return $this->boost; }

    public function setBoost(?GuildBoost $boost): self
    {
        $this->boost = $boost;
        return $this;
    }
}
