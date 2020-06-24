<?php

namespace App\Entity;

use App\Repository\QuestKeyRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuestKeyRepository::class)
 */
class QuestKey
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
    private $rate;

    /**
     * @ORM\OneToOne(targetEntity=Quest::class, inversedBy="keyDrop")
     * 
     * @JMS\MaxDepth(1)
     */
    private $quest;

    /**
     * @ORM\OneToOne(targetEntity=Consumable::class)
     * 
     * @JMS\MaxDepth(1)
     */
    private $keyDrop;

    public function getId(): ?int { return $this->id; }

    public function getRate(): ?int { return $this->rate; }

    public function setRate(int $rate): self
    {
        $this->rate = $rate;
        return $this;
    }

    public function getQuest(): ?Quest { return $this->quest; }

    public function setQuest(?Quest $quest): self
    {
        $this->quest = $quest;
        return $this;
    }

    public function getKeyDrop(): ?Consumable { return $this->keyDrop; }

    public function setKeyDrop(?Consumable $keyDrop): self
    {
        $this->keyDrop = $keyDrop;
        return $this;
    }
}
