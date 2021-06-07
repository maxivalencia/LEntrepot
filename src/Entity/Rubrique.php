<?php

namespace App\Entity;

use App\Repository\RubriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RubriqueRepository::class)
 */
class Rubrique
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
    private $nom;

    /**
     * @ORM\ManyToOne(targetEntity=Typeprojet::class, inversedBy="rubriques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $typeprojet;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTypeprojet(): ?typeprojet
    {
        return $this->typeprojet;
    }

    public function setTypeprojet(?typeprojet $typeprojet): self
    {
        $this->typeprojet = $typeprojet;

        return $this;
    }

    /**
    * toString
    * @return string
    */
    public function __toString()
    {
        return $this->getNom();
    }
}
