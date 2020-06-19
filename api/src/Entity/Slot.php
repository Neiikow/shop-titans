<?php

namespace App\Entity;

use App\Repository\SlotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SlotRepository::class)
 */
class Slot
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
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $img;

    /**
     * @ORM\OneToMany(targetEntity=SlotSize::class, mappedBy="slot", orphanRemoval=true)
     */
    private $sizes;

    public function __construct()
    {
        $this->sizes = new ArrayCollection();
    }

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

    /**
     * @return Collection|SlotSize[]
     */
    public function getSizes(): Collection { return $this->sizes; }

    public function addSize(SlotSize $size): self
    {
        if (!$this->sizes->contains($size)) {
            $this->sizes[] = $size;
            $size->setSlot($this);
        }

        return $this;
    }

    public function removeSize(SlotSize $size): self
    {
        if ($this->sizes->contains($size)) {
            $this->sizes->removeElement($size);

            if ($size->getSlot() === $this) {
                $size->setSlot(null);
            }
        }

        return $this;
    }
}
