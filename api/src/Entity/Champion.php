<?php

namespace App\Entity;

use App\Repository\ChampionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChampionRepository::class)
 */
class Champion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $title;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $coinCost;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $hp;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $atk;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $def;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $eva;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $critRate;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $critDmg;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $threat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $prerequisite;

    /**
     * @ORM\OneToOne(targetEntity=Character::class)
     * 
     * @JMS\MaxDepth(1)
     */
    private $leader;

    /**
     * @ORM\OneToMany(targetEntity=Skill::class, mappedBy="champion")
     * 
     * @JMS\MaxDepth(2)
     */
    private $skill;

    public function __construct()
    {
        $this->skill = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getDescription(): ?string { return $this->description; }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getTitle(): ?string { return $this->title; }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getCoinCost(): ?int
    { return $this->coinCost; }

    public function setCoinCost(?int $coinCost): self
    {
        $this->coinCost = $coinCost;
        return $this;
    }

    public function getHp(): ?int { return $this->hp; }

    public function setHp(int $hp): self
    {
        $this->hp = $hp;
        return $this;
    }

    public function getAtk(): ?int { return $this->atk; }

    public function setAtk(int $atk): self
    {
        $this->atk = $atk;
        return $this;
    }

    public function getDef(): ?int { return $this->def; }

    public function setDef(int $def): self
    {
        $this->def = $def;
        return $this;
    }

    public function getEva(): ?int { return $this->eva; }

    public function setEva(int $eva): self
    {
        $this->eva = $eva;
        return $this;
    }

    public function getCritRate(): ?int { return $this->critRate; }

    public function setCritRate(int $critRate): self
    {
        $this->critRate = $critRate;
        return $this;
    }

    public function getCritDmg(): ?int { return $this->critDmg; }

    public function setCritDmg(int $critDmg): self
    {
        $this->critDmg = $critDmg;
        return $this;
    }

    public function getThreat(): ?int { return $this->threat; }

    public function setThreat(int $threat): self
    {
        $this->threat = $threat;
        return $this;
    }

    public function getPrerequisite(): ?string { return $this->prerequisite; }

    public function setPrerequisite(?string $prerequisite): self
    {
        $this->prerequisite = $prerequisite;
        return $this;
    }

    public function getLeader(): ?Character { return $this->leader; }

    public function setLeader(?Character $leader): self
    {
        $this->leader = $leader;
        return $this;
    }

    /**
     * @return Collection|Skill[]
     */
    public function getSkill(): Collection { return $this->skill; }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skill->contains($skill)) {
            $this->skill[] = $skill;
            $skill->setChampion($this);
        }

        return $this;
    }

    public function removeSkill(Skill $skill): self
    {
        if ($this->skill->contains($skill)) {
            $this->skill->removeElement($skill);

            if ($skill->getChampion() === $this) {
                $skill->setChampion(null);
            }
        }

        return $this;
    }
}
