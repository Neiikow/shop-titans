<?php

namespace App\Entity;

use App\Repository\HeroRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=HeroRepository::class)
 */
class Hero
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
    private $class;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $subClass;

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
     * @ORM\Column(type="array")
     * 
     * @Assert\Type("array")
     */
    private $skillSlotLvl = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $goldCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Length(max="255")
     * @Assert\Type("string")
     */
    private $element;

    public function getId(): ?int { return $this->id; }

    public function getClass(): ?string { return $this->class; }

    public function setClass(string $class): self
    {
        $this->class = $class;
        return $this;
    }

    public function getSubClass(): ?string { return $this->subClass; }

    public function setSubClass(string $subClass): self
    {
        $this->subClass = $subClass;
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

    public function getSkillSlotLvl(): ?array { return $this->skillSlotLvl; }

    public function setSkillSlotLvl(array $skillSlotLvl): self
    {
        $this->skillSlotLvl = $skillSlotLvl;
        return $this;
    }

    public function getGoldCost(): ?int { return $this->goldCost; }

    public function setGoldCost(?int $goldCost): self
    {
        $this->goldCost = $goldCost;
        return $this;
    }

    public function getGemCost(): ?int { return $this->gemCost; }

    public function setGemCost(?int $gemCost): self
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

    public function getElement(): ?string { return $this->element; }

    public function setElement(?string $element): self
    {
        $this->element = $element;
        return $this;
    }
}
