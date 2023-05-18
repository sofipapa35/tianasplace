<?php

namespace App\Entity;

use App\Repository\DisponibilityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DisponibilityRepository::class)
 */
class Disponibility
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Jour::class, inversedBy="disponibilities", cascade={"persist", "remove"})
     */
    private $jour;

    /**
     * @ORM\ManyToOne(targetEntity=Heure::class, inversedBy="disponibilities")
     */
    private $heure;

    /**
     * @ORM\ManyToOne(targetEntity=Personnes::class, inversedBy="disponibilities")
     */
    private $personnes;

    /**
     * @ORM\Column(type="integer")
     */
    private $count;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?Jour
    {
        return $this->jour;
    }

    public function setJour(?Jour $jour): self
    {
        $this->jour = $jour;

        return $this;
    }

    public function getHeure(): ?Heure
    {
        return $this->heure;
    }

    public function setHeure(?Heure $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getPersonnes(): ?Personnes
    {
        return $this->personnes;
    }

    public function setPersonnes(?Personnes $personnes): self
    {
        $this->personnes = $personnes;

        return $this;
    }

    public function getCount(): ?int
    {
        return $this->count;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;

        return $this;
    }
}
