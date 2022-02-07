<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre prénom doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Votre prénom ne peut pas dépasser {{ limit }} caractères.',
    )]
    private string $firstname;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Votre nom doit comporter au moins {{ limit }} caractères.',
        maxMessage: 'Votre nom ne peut pas dépasser {{ limit }} caractères.',
    )]
    private string $name;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Assert\Email(
        message: "L'e-mail {{ value }} n'est pas un e-mail valide.",
    )]
    private $email;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    #[Assert\Length(
        min: 5,
        minMessage: 'Votre message doit comporter au moins {{ limit }} caractères',
    )]
    private string $message;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'contacts')]
    #[Assert\NotNull]
    private Company $department;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getDepartment(): ?Company
    {
        return $this->department;
    }

    public function setDepartment(?Company $department): self
    {
        $this->department = $department;

        return $this;
    }
}
