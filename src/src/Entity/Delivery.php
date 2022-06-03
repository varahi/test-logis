<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $baseUrl;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $weight;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="deliveries")
     */
    private $departure;

    /**
     * @ORM\ManyToOne(targetEntity=Location::class, inversedBy="deliveries")
     */
    private $destination;

    /**
     * @ORM\Column(type="datetime")
     */
    private $fromDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $toDate;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="deliveries")
     */
    private $company;

    public function __toString(): string
    {
        return 'ID - ' . $this->id . ' ' .$this->departure .' - '. $this->destination;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getBaseUrl(): ?string
    {
        return $this->baseUrl;
    }

    public function setBaseUrl(string $baseUrl): self
    {
        $this->baseUrl = $baseUrl;

        return $this;
    }

    public function getWeight(): ?string
    {
        return $this->weight;
    }

    public function setWeight(?string $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getDeparture(): ?Location
    {
        return $this->departure;
    }

    public function setDeparture(?Location $departure): self
    {
        $this->departure = $departure;

        return $this;
    }

    public function getDestination(): ?Location
    {
        return $this->destination;
    }

    public function setDestination(?Location $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getFromDate(): ?\DateTimeInterface
    {
        return $this->fromDate;
    }

    public function setFromDate(\DateTimeInterface $fromDate): self
    {
        $this->fromDate = $fromDate;

        return $this;
    }

    public function getToDate(): ?\DateTimeInterface
    {
        return $this->toDate;
    }

    public function setToDate(\DateTimeInterface $toDate): self
    {
        $this->toDate = $toDate;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
