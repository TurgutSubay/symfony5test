<?php

namespace App\Entity;

use App\Repository\OfficesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\JoinColumn;

/**
 * @ORM\Entity
 * @ORM\Table(name="offices")
 * @ORM\Entity(repositoryClass=OfficesRepository::class)
 */
class Offices
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime",options={"default": "CURRENT_TIMESTAMP"})
     */
    private $created_date;

    /**
     * @ORM\Column(type="datetime", nullable=true, columnDefinition="DATETIME on update CURRENT_TIMESTAMP")
     */
    private $updated_date;

    /**
     * One Category has Many Categories.
     * @ORM\OneToMany(targetEntity="App\Entity\Personnel", mappedBy="office")
     */
    private $personnel;

    public function __construct()
    {
        $this->personnel = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->created_date;
    }

    public function setCreatedDate(\DateTimeInterface $created_date): self
    {
        $this->created_date = $created_date;

        return $this;
    }

    public function getUpdatedDate(): ?\DateTimeInterface
    {
        return $this->updated_date;
    }

    public function setUpdatedDate(?\DateTimeInterface $updated_date): self
    {
        $this->updated_date = $updated_date;

        return $this;
    }

    /**
     * @return Collection|Personnel[]
     */
    public function getPersonnel(): Collection
    {
        return $this->personnel;
    }

    public function addPersonnel(Personnel $personnel): self
    {
        if (!$this->personnel->contains($personnel)) {
            $this->personnel[] = $personnel;
            $personnel->setOffice($this);
        }

        return $this;
    }

    public function removePersonnel(Personnel $personnel): self
    {
        if ($this->personnel->removeElement($personnel)) {
            // set the owning side to null (unless already changed)
            if ($personnel->getOffice() === $this) {
                $personnel->setOffice(null);
            }
        }

        return $this;
    }
}
