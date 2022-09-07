<?php

namespace App\Entity;

use App\Repository\AppointmentsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AppointmentsRepository::class)]
class Appointments
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date = null;

    #[ORM\Column]
    private ?int $Location_ID = null;

    #[ORM\Column]
    private ?int $User_ID = null;

    #[ORM\ManyToOne(targetEntity: User::class, fetch: 'EXTRA_LAZY', inversedBy: 'appointments')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: false)]
    protected User $user;

    #[ORM\ManyToOne(targetEntity: Locations::class, fetch: 'EXTRA_LAZY', inversedBy: 'appointments')]
    #[ORM\JoinColumn(name: 'location_id', referencedColumnName: 'id', nullable: false)]
    protected Locations $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getLocationID(): ?int
    {
        return $this->Location_ID;
    }

    public function setLocationID(int $Location_ID): self
    {
        $this->Location_ID = $Location_ID;

        return $this;
    }

    public function getUserID(): ?int
    {
        return $this->User_ID;
    }

    public function setUserID(int $User_ID): self
    {
        $this->User_ID = $User_ID;

        return $this;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return Locations
     */
    public function getLocation(): Locations
    {
        return $this->location;
    }

    /**
     * @param Locations $location
     */
    public function setLocation(Locations $location): void
    {
        $this->location = $location;
    }

}
