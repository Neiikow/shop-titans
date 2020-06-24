<?php

namespace App\Entity;

use App\Repository\QuestComponentRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestComponentRepository::class)
 */
class QuestComponent
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
    private $min;

    /**
     * @ORM\Column(type="integer")
     * 
     * @JMS\Type("strict_integer")
     * 
     * @Assert\NotBlank
     * @Assert\Type("integer")
     */
    private $max;

    /**
     * @ORM\ManyToOne(targetEntity=Component::class, inversedBy="quests")
     * 
     * @JMS\MaxDepth(1)
     */
    private $component;

    /**
     * @ORM\ManyToOne(targetEntity=Quest::class, inversedBy="components")
     * 
     * @JMS\MaxDepth(1)
     */
    private $quest;

    public function getId(): ?int { return $this->id; }

    public function getMin(): ?int { return $this->min; }

    public function setMin(int $min): self
    {
        $this->min = $min;
        return $this;
    }

    public function getMax(): ?int { return $this->max; }

    public function setMax(int $max): self
    {
        $this->max = $max;
        return $this;
    }

    public function getComponent(): ?Component { return $this->component; }

    public function setComponent(?Component $component): self
    {
        $this->component = $component;
        return $this;
    }

    public function getQuest(): ?Quest { return $this->quest; }

    public function setQuest(?Quest $quest): self
    {
        $this->quest = $quest;
        return $this;
    }
}
