<?php

namespace App\Entity;

use App\Repository\ComponentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ComponentRepository::class)
 */
class Component
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
    private $description;

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
    private $tier;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $goldValue;

    /**
     * @ORM\ManyToOne(targetEntity=QuestArea::class, inversedBy="components")
     * 
     * @JMS\MaxDepth(1)
     */
    private $area;

    /**
     * @ORM\OneToMany(targetEntity=QuestComponent::class, mappedBy="component", orphanRemoval=true)
     */
    private $quests;

    public function __construct()
    {
        $this->quests = new ArrayCollection();
    }

    public function getId(): ?int { return $this->id; }

    public function getName(): ?string { return $this->name; }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string { return $this->description; }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImg(): ?string { return $this->img; }

    public function setImg(?string $img): self
    {
        $this->img = $img;
        return $this;
    }

    public function getTier(): ?int { return $this->tier; }

    public function setTier(int $tier): self
    {
        $this->tier = $tier;
        return $this;
    }

    public function getGoldValue(): ?int { return $this->goldValue; }

    public function setGoldValue(int $goldValue): self
    {
        $this->goldValue = $goldValue;
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
    public function getQuests(): Collection { return $this->quests; }

    public function addQuest(QuestComponent $quest): self
    {
        if (!$this->quests->contains($quest)) {
            $this->quests[] = $quest;
            $quest->setComponent($this);
        }

        return $this;
    }

    public function removeQuest(QuestComponent $quest): self
    {
        if ($this->quests->contains($quest)) {
            $this->quests->removeElement($quest);

            if ($quest->getComponent() === $this) {
                $quest->setComponent(null);
            }
        }

        return $this;
    }
}
