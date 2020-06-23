<?php

namespace App\Entity;

use App\Repository\ChampionRankRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ChampionRankRepository::class)
 */
class ChampionRank
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
    private $rank;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $coinCost;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $hpIncrease;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $atkIncrease;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $defIncrease;

    /**
     * @ORM\OneToOne(targetEntity=Skill::class)
     * 
     * @JMS\MaxDepth(1)
     */
    private $skillUnlock;

    /**
     * @ORM\ManyToOne(targetEntity=Champion::class, inversedBy="ranks")
     * 
     * @JMS\MaxDepth(1)
     */
    private $champion;

    public function getId(): ?int { return $this->id; }

    public function getRank(): ?int { return $this->rank; }

    public function setRank(int $rank): self
    {
        $this->rank = $rank;
        return $this;
    }

    public function getCoinCost(): ?int { return $this->coinCost; }

    public function setCoinCost(?int $coinCost): self
    {
        $this->coinCost = $coinCost;
        return $this;
    }

    public function getHpIncrease(): ?int { return $this->hpIncrease; }

    public function setHpIncrease(?int $hpIncrease): self
    {
        $this->hpIncrease = $hpIncrease;
        return $this;
    }

    public function getAtkIncrease(): ?int { return $this->atkIncrease; }

    public function setAtkIncrease(?int $atkIncrease): self
    {
        $this->atkIncrease = $atkIncrease;
        return $this;
    }

    public function getDefIncrease(): ?int { return $this->defIncrease; }

    public function setDefIncrease(?int $defIncrease): self
    {
        $this->defIncrease = $defIncrease;
        return $this;
    }

    public function getSkillUnlock(): ?Skill { return $this->skillUnlock; }

    public function setSkillUnlock(?Skill $skillUnlock): self
    {
        $this->skillUnlock = $skillUnlock;
        return $this;
    }

    public function getChampion(): ?Champion { return $this->champion; }

    public function setChampion(?Champion $champion): self
    {
        $this->champion = $champion;
        return $this;
    }
}
