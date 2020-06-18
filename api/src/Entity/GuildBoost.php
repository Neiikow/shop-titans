<?php

namespace App\Entity;

use App\Repository\GuildBoostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GuildBoostRepository::class)
 */
class GuildBoost
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
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $effect;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $baseDuration;

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
     * @ORM\OneToMany(targetEntity=GuildUpgrade::class, mappedBy="boost", orphanRemoval=true)
     */
    private $upgrades;

    public function __construct()
    {
        $this->upgrades = new ArrayCollection();
    }

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

    public function getEffect(): ?string { return $this->effect; }

    public function setEffect(string $effect): self
    {
        $this->effect = $effect;
        return $this;
    }

    public function getBaseDuration(): ?int { return $this->baseDuration; }

    public function setBaseDuration(int $baseDuration): self
    {
        $this->baseDuration = $baseDuration;
        return $this;
    }

    public function getRenowmCost(): ?int { return $this->renowmCost; }

    public function setRenowmCost(int $renowmCost): self
    {
        $this->renowmCost = $renowmCost;
        return $this;
    }

    /**
     * @return Collection|GuildUpgrade[]
     */
    public function getUpgrades(): Collection { return $this->upgrades; }

    public function addUpgrade(GuildUpgrade $upgrade): self
    {
        if (!$this->upgrades->contains($upgrade)) {
            $this->upgrades[] = $upgrade;
            $upgrade->setBoost($this);
        }

        return $this;
    }

    public function removeUpgrade(GuildUpgrade $upgrade): self
    {
        if ($this->upgrades->contains($upgrade)) {
            $this->upgrades->removeElement($upgrade);
            
            if ($upgrade->getBoost() === $this) {
                $upgrade->setBoost(null);
            }
        }

        return $this;
    }
}
