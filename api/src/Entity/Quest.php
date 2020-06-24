<?php

namespace App\Entity;

use App\Repository\QuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestRepository::class)
 */
class Quest
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
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $difficulty;

    /**
     * @ORM\Column(type="boolean")
     * 
     * @Assert\Type("boolean")
     */
    private $isBoss;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $powerRequired;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $xp;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $questTime;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $restTime;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $healTime;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $itemMin;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $itemMax;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $monsterHp;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $monsterBaseDmg;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $monsterAoeDmg;

    /**
     * @ORM\ManyToOne(targetEntity=QuestArea::class, inversedBy="quests")
     * 
     * @JMS\MaxDepth(1)
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity=QuestComponent::class, mappedBy="quest", orphanRemoval=true)
     */
    private $components;

    public function __construct()
    {
        $this->components = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDifficulty(): ?string { return $this->difficulty; }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;
        return $this;
    }

    public function getIsBoss(): ?bool { return $this->isBoss; }

    public function setIsBoss(bool $isBoss): self
    {
        $this->isBoss = $isBoss;
        return $this;
    }

    public function getPowerRequired(): ?int { return $this->powerRequired; }

    public function setPowerRequired(int $powerRequired): self
    {
        $this->powerRequired = $powerRequired;
        return $this;
    }

    public function getXp(): ?int { return $this->xp; }

    public function setXp(int $xp): self
    {
        $this->xp = $xp;
        return $this;
    }

    public function getQuestTime(): ?int { return $this->questTime; }

    public function setQuestTime(int $questTime): self
    {
        $this->questTime = $questTime;
        return $this;
    }

    public function getRestTime(): ?int { return $this->restTime; }

    public function setRestTime(int $restTime): self
    {
        $this->restTime = $restTime;
        return $this;
    }

    public function getHealTime(): ?int { return $this->healTime; }

    public function setHealTime(int $healTime): self
    {
        $this->healTime = $healTime;
        return $this;
    }

    public function getItemMin(): ?int { return $this->itemMin; }

    public function setItemMin(int $itemMin): self
    {
        $this->itemMin = $itemMin;
        return $this;
    }

    public function getItemMax(): ?int { return $this->itemMax; }

    public function setItemMax(int $itemMax): self
    {
        $this->itemMax = $itemMax;
        return $this;
    }

    public function getMonsterHp(): ?int { return $this->monsterHp; }

    public function setMonsterHp(int $monsterHp): self
    {
        $this->monsterHp = $monsterHp;
        return $this;
    }

    public function getMonsterBaseDmg(): ?int { return $this->monsterBaseDmg; }

    public function setMonsterBaseDmg(int $monsterBaseDmg): self
    {
        $this->monsterBaseDmg = $monsterBaseDmg;
        return $this;
    }

    public function getMonsterAoeDmg(): ?int { return $this->monsterAoeDmg; }

    public function setMonsterAoeDmg(int $monsterAoeDmg): self
    {
        $this->monsterAoeDmg = $monsterAoeDmg;
        return $this;
    }

    public function getArea(): ?QuestArea { return $this->area; }

    public function setArea(?QuestArea $area): self
    {
        $this->area = $area;
        return $this;
    }

    /**
     * @return Collection|QuestComponent[]
     */
    public function getComponents(): Collection { return $this->components; }

    public function addComponent(QuestComponent $component): self
    {
        if (!$this->components->contains($component)) {
            $this->components[] = $component;
            $component->setQuest($this);
        }

        return $this;
    }

    public function removeComponent(QuestComponent $component): self
    {
        if ($this->components->contains($component)) {
            $this->components->removeElement($component);

            if ($component->getQuest() === $this) {
                $component->setQuest(null);
            }
        }

        return $this;
    }
}
