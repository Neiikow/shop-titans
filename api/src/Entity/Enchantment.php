<?php

namespace App\Entity;

use App\Repository\EnchantmentRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=EnchantmentRepository::class)
 */
class Enchantment
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
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $effect;

    /**
     * @ORM\ManyToOne(targetEntity=ItemType::class)
     * 
     * @JMS\MaxDepth(1)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $img;

    public function getId(): ?int { return $this->id; }

    public function getEffect(): ?string { return $this->effect; }

    public function setEffect(string $effect): self
    {
        $this->effect = $effect;
        return $this;
    }

    public function getType(): ?ItemType { return $this->type; }

    public function setType(?ItemType $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getImg(): ?string { return $this->img; }

    public function setImg(?string $img): self
    {
        $this->img = $img;
        return $this;
    }
}
