<?php

namespace App\Entity;

use App\Repository\WorkerRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=WorkerRepository::class)
 */
class Worker
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
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $job;

    /**
     * @ORM\OneToOne(targetEntity=Character::class)
     * 
     * @JMS\MaxDepth(1)
     */
    private $artisan;

    /**
     * @ORM\OneToOne(targetEntity=Pack::class, inversedBy="worker")
     * 
     * @JMS\MaxDepth(1)
     */
    private $pack;

    public function getId(): ?int { return $this->id; }

    public function getDescription(): ?string { return $this->description; }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getJob(): ?string { return $this->job; }

    public function setJob(string $job): self
    {
        $this->job = $job;
        return $this;
    }

    public function getArtisan(): ?Character { return $this->artisan; }

    public function setArtisan(?Character $artisan): self
    {
        $this->artisan = $artisan;
        return $this;
    }

    public function getPack(): ?Pack { return $this->pack; }

    public function setPack(?Pack $pack): self
    {
        $this->pack = $pack;
        return $this;
    }
}
