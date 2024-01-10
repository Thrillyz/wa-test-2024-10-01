<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Controller\Api\CreateJobController;
use App\Repository\JobsRepository;
use ApiPlatform\Metadata\ApiResource;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: JobsRepository::class)]
#[ApiResource(
    operations : [
        new GetCollection(),
        new Post(
            uriTemplate: '/people/{id}/jobs',
            controller: CreateJobController::class,
            read: false,
            name: 'create_job_by_people'
        )
    ],
    denormalizationContext: ['groups' => ['write']],
)]
#[ApiFilter(SearchFilter::class, properties: ['person.id' => 'exact'])]
#[ApiFilter(DateFilter::class, properties: ['beginAt', 'endAt'])]

class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $company = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $position = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['read', 'write'])]
    private ?DateTimeImmutable $beginAt = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    #[Groups(['read', 'write'])]
    private ?DateTimeImmutable $endAt = null;

    #[ORM\ManyToOne(inversedBy: 'jobs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Person $person = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): static
    {
        $this->company = $company;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): static
    {
        $this->position = $position;

        return $this;
    }

    public function getBeginAt(): ?DateTimeImmutable
    {
        return $this->beginAt;
    }

    public function setBeginAt(DateTimeImmutable $beginAt): static
    {
        $this->beginAt = $beginAt;

        return $this;
    }

    public function getEndAt(): ?DateTimeImmutable
    {
        return $this->endAt;
    }

    public function setEndAt(?DateTimeImmutable $endAt): static
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getPerson(): ?Person
    {
        return $this->person;
    }

    public function setPerson(?Person $person): static
    {
        $this->person = $person;

        return $this;
    }
}
