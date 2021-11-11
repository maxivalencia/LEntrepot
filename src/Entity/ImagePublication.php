<?php

namespace App\Entity;

use App\Repository\ImagePublicationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ImagePublicationRepository::class)
 */
class ImagePublication
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
    private $nomFichier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomServer;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $referenceImage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomFichier(): ?string
    {
        return $this->nomFichier;
    }

    public function setNomFichier(string $nomFichier): self
    {
        $this->nomFichier = $nomFichier;

        return $this;
    }

    public function getNomServer(): ?string
    {
        return $this->nomServer;
    }

    public function setNomServer(string $nomServer): self
    {
        $this->nomServer = $nomServer;

        return $this;
    }

    public function getReferenceImage(): ?string
    {
        return $this->referenceImage;
    }

    public function setReferenceImage(string $referenceImage): self
    {
        $this->referenceImage = $referenceImage;

        return $this;
    }
}
