<?php

namespace App\Entity;

use App\Repository\QuestLvlRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestLvlRepository::class)
 */
class QuestLvl
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
    private $effect;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\Type("integer")
     */
    private $xpNeeded;

    /**
     * @ORM\ManyToOne(targetEntity=QuestArea::class, inversedBy="lvls")
     * 
     * @JMS\MaxDepth(1)
     */
    private $area;

    public function getId(): ?int { return $this->id; }

    public function getLvl(): ?int { return $this->lvl; }

    public function setLvl(int $lvl): self
    {
        $this->lvl = $lvl;
        return $this;
    }

    public function getEffect(): ?string { return $this->effect; }

    public function setEffect(string $effect): self
    {
        $this->effect = $effect;
        return $this;
    }

    public function getXpNeeded(): ?int { return $this->xpNeeded; }

    public function setXpNeeded(?int $xpNeeded): self
    {
        $this->xpNeeded = $xpNeeded;
        return $this;
    }

    public function getArea(): ?QuestArea { return $this->area; }

    public function setArea(?QuestArea $area): self
    {
        $this->area = $area;
        return $this;
    }
}
