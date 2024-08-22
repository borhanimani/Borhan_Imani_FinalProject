<?php

namespace App\Entity;

use App\Repository\SystemInformationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SystemInformationRepository::class)]
class SystemInformation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $ram = null;

    #[ORM\Column(length: 255)]
    private ?string $cpu = null;

    #[ORM\Column(nullable: true)]
    private ?int $hard = null;

    #[ORM\Column(nullable: true)]
    private ?int $ssd = null;

    #[ORM\Column(length: 255)]
    private ?string $gpu = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRam(): ?int
    {
        return $this->ram;
    }

    public function setRam(int $ram): static
    {
        $this->ram = $ram;

        return $this;
    }

    public function getCpu(): ?string
    {
        return $this->cpu;
    }

    public function setCpu(string $cpu): static
    {
        $this->cpu = $cpu;

        return $this;
    }

    public function getHard(): ?int
    {
        return $this->hard;
    }

    public function setHard(?int $hard): static
    {
        $this->hard = $hard;

        return $this;
    }

    public function getSsd(): ?int
    {
        return $this->ssd;
    }

    public function setSsd(?int $ssd): static
    {
        $this->ssd = $ssd;

        return $this;
    }

    public function getGpu(): ?string
    {
        return $this->gpu;
    }

    public function setGpu(string $gpu): static
    {
        $this->gpu = $gpu;

        return $this;
    }

    public function getInfo(): string
    {
        return ('Ram: '.$this->ram.'GB, CPU: ' .$this->cpu . ', GPU: ' . $this->gpu . ', Memory: ' . $this->hard. 'TB, SSD: ' . $this->ssd);
    }

    public function __toString(): string
    {
        return ('Ram: '.$this->ram.'GB, CPU: ' .$this->cpu . ', GPU: ' . $this->gpu . ', Memory: ' . $this->hard. 'TB, SSD: ' . $this->ssd);
    }
}
