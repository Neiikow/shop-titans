<?php

namespace App\Entity;

use App\Repository\PackRepository;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=PackRepository::class)
 */
class Pack
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @JMS\Type("strict_string")
     * 
     * @Assert\Type("string")
     * @Assert\Length(max="255")
     */
    private $description;

    /**
     * @ORM\Column(type="date", nullable=true)
     * 
     * @Assert\Type("date")
     */
    private $releaseDate;

    /**
     * @ORM\OneToOne(targetEntity=Worker::class, mappedBy="pack")
     */
    private $worker;

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

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface { return $this->releaseDate; }

    public function setReleaseDate(?\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }

    public function getWorker(): ?Worker { return $this->worker; }

    public function setWorker(?Worker $worker): self
    {
        $this->worker = $worker;

        $newPack = null === $worker ? null : $this;
        if ($worker->getPack() !== $newPack) {
            $worker->setPack($newPack);
        }

        return $this;
    }
}
