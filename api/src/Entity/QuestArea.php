<?php

namespace App\Entity;

use App\Repository\QuestAreaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\OneToMany(targetEntity=Component::class, mappedBy="area")
     */
    private $components;

    /**
     * @ORM\OneToMany(targetEntity=QuestLvl::class, mappedBy="area")
     */
    private $lvls;

    /**
     * @ORM\OneToOne(targetEntity=QuestBoss::class, mappedBy="area")
     */
    private $boss;

    /**
     * @ORM\OneToMany(targetEntity=Quest::class, mappedBy="area")
     */
    private $quests;

    public function __construct()
    {
        $this->components = new ArrayCollection();
        $this->lvls = new ArrayCollection();
        $this->quests = new ArrayCollection();
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

    /**
     * @return Collection|Component[]
     */
    public function getComponents(): Collection { return $this->components; }

    public function addComponent(Component $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components[] = $component;
            $component->setArea($this);
        }

        return $this;
    }

    public function removeComponent(Component $component): self
    {
        if ($this->components->contains($component)) {
            $this->components->removeElement($component);

            if ($component->getArea() === $this) {
                $component->setArea(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|QuestLvl[]
     */
    public function getLvls(): Collection { return $this->lvls; }

    public function addLvl(QuestLvl $lvl): self
    {
        if (!$this->lvls->contains($lvl)) {
            $this->lvls[] = $lvl;
            $lvl->setArea($this);
        }

        return $this;
    }

    public function removeLvl(QuestLvl $lvl): self
    {
        if ($this->lvls->contains($lvl)) {
            $this->lvls->removeElement($lvl);

            if ($lvl->getArea() === $this) {
                $lvl->setArea(null);
            }
        }

        return $this;
    }

    public function getBoss(): ?QuestBoss { return $this->boss; }

    public function setBoss(?QuestBoss $boss): self
    {
        $this->boss = $boss;

        $newArea = null === $boss ? null : $this;
        if ($boss->getArea() !== $newArea) {
            $boss->setArea($newArea);
        }

        return $this;
    }

    /**
     * @return Collection|Quest[]
     */
    public function getQuests(): Collection { return $this->quests; }

    public function addQuest(Quest $quest): self
    {
        if (!$this->quests->contains($quest)) {
            $this->quests[] = $quest;
            $quest->setArea($this);
        }

        return $this;
    }

    public function removeQuest(Quest $quest): self
    {
        if ($this->quests->contains($quest)) {
            $this->quests->removeElement($quest);

            if ($quest->getArea() === $this) {
                $quest->setArea(null);
            }
        }

        return $this;
    }
}
