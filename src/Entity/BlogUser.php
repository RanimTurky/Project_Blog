<?php

namespace App\Entity;

use App\Repository\BlogUserRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BlogUserRepository::class)]
class BlogUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomDeLaPropriete = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $blogproerity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomDeLaPropriete(): ?string
    {
        return $this->nomDeLaPropriete;
    }

    public function setNomDeLaPropriete(string $nomDeLaPropriete): static
    {
        $this->nomDeLaPropriete = $nomDeLaPropriete;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getBlogproerity(): ?string
    {
        return $this->blogproerity;
    }

    public function setBlogproerity(string $blogproerity): static
    {
        $this->blogproerity = $blogproerity;

        return $this;
    }
}
