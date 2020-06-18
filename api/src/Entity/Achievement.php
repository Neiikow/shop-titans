<?php

namespace App\Entity;

use App\Repository\AchievementRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AchievementRepository::class)
 */
class Achievement
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
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $tier;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $gemReward;

    /**
     * @ORM\OneToOne(targetEntity=Achievement::class, inversedBy="nextTier")
     */
    private $prevTier;

    /**
     * @ORM\OneToOne(targetEntity=Achievement::class, mappedBy="prevTier", orphanRemoval=true)
     */
    private $nextTier;

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

    public function getTier(): ?int { return $this->tier; }

    public function setTier(int $tier): self
    {
        $this->tier = $tier;
        return $this;
    }

    public function getGemReward(): ?int { return $this->gemReward; }

    public function setGemReward(int $gemReward): self
    {
        $this->gemReward = $gemReward;
        return $this;
    }

    public function getPrevTier(): ?self { return $this->prevTier; }

    public function setPrevTier(?self $prevTier): self
    {
        $this->prevTier = $prevTier;
        return $this;
    }

    public function getNextTier(): ?self { return $this->nextTier; }

    public function setNextTier(?self $nextTier): self
    {
        $this->nextTier = $nextTier;

        $newPrevTier = null === $nextTier ? null : $this;
        if ($nextTier->getPrevTier() !== $newPrevTier) {
            $nextTier->setPrevTier($newPrevTier);
        }

        return $this;
    }
}
