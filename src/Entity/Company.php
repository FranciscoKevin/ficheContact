<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $departmentName;

    #[ORM\Column(type: 'string', length: 255)]
    private $email;

    #[ORM\OneToMany(mappedBy: 'department', targetEntity: Contact::class)]
    private $contacts;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartmentName(): ?string
    {
        return $this->departmentName;
    }

    public function setDepartmentName(string $departmentName): self
    {
        $this->departmentName = $departmentName;

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

    /**
     * @return Collection|Contact[]
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): self
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts[] = $contact;
            $contact->setDepartment($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): self
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getDepartment() === $this) {
                $contact->setDepartment(null);
            }
        }

        return $this;
    }
}
