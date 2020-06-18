<?php

namespace App\Entity;

use App\Repository\GuildPerkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=GuildPerkRepository::class)
 */
class GuildPerk
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
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=GuildUpgrade::class, mappedBy="perk", orphanRemoval=true)
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

    public function getDescription(): ?string { return $this->description; }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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
            $upgrade->setPerk($this);
        }

        return $this;
    }

    public function removeUpgrade(GuildUpgrade $upgrade): self
    {
        if ($this->upgrades->contains($upgrade)) {
            $this->upgrades->removeElement($upgrade);

            if ($upgrade->getPerk() === $this) {
                $upgrade->setPerk(null);
            }
        }

        return $this;
    }
}
