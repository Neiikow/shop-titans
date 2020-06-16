<?php

namespace App\Entity;

use App\Repository\FriendshipLvlRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=FriendshipLvlRepository::class)
 */
class FriendshipLvl
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
    private $rankName;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $nrgBonus;

    public function getId(): ?int { return $this->id; }

    public function getLvl(): ?int { return $this->lvl; }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;
        return $this;
    }

    public function getRankName(): ?string { return $this->rankName; }

    public function setRankName(string $rankName): self
    {
        $this->rankName = $rankName;
        return $this;
    }

    public function getNrgBonus(): ?int { return $this->nrgBonus; }

    public function setNrgBonus(int $nrgBonus): self
    {
        $this->nrgBonus = $nrgBonus;
        return $this;
    }
}
