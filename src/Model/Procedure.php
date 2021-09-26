<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Model;

class Procedure extends BaseModel
{
    const DRAFT_STATUS = 'draft';
    const ACTIVE_STATUS = 'active';
    const FINISHED_STATUS = 'finished';
    const EXPIRED_STATUS = 'expired';
    const REFUSED_STATUS = 'refused';

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface
     */
    protected $updatedAt;

    /**
     * @var \DateTimeInterface
     */
    protected $finishedAt;

    /**
     * @var \DateTimeInterface
     */
    protected $expiresAt;

    /**
     * @var string
     */
    protected $status;

    /**
     * @var string
     */
    protected $creator;

    /**
     * @var string
     */
    protected $creatorFirstName;

    /**
     * @var string
     */
    protected $creatorLastName;

    /**
     * @var string
     */
    protected $company;

    /**
     * @var array
     */
    protected $members = [];

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var array
     */
    protected $files = [];

    protected $subObjects = [
        'members' => Member::class,
        'files' => File::class,
    ];

    /**
     * @var bool
     */
    protected $archive;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?string
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getFinishedAt(): ?string
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    public function getExpiresAt(): ?string
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeInterface $expiresAt): self
    {
        $this->expiresAt = $expiresAt;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreator(): ?string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): self
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCreatorFirstName(): ?string
    {
        return $this->creatorFirstName;
    }

    public function setCreatorFirstName(string $creatorFirstName): self
    {
        $this->creatorFirstName = $creatorFirstName;

        return $this;
    }

    public function getCreatorLastName(): ?string
    {
        return $this->creatorLastName;
    }

    public function setCreatorLastName(string $creatorLastName): self
    {
        $this->creatorLastName = $creatorLastName;

        return $this;
    }

    public function getCompany(): ?string
    {
        return $this->company;
    }

    public function setCompany(string $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getMembers(): array
    {
        return $this->members;
    }

    public function addMember(Member $member): self
    {
        if (!\in_array($member, $this->members, true)) {
            $this->members[] = $member;
        }

        return $this;
    }


    public function getConfig(): array
    {
        return $this->config;
    }

    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function getFiles(): array
    {
        return $this->files;
    }

    public function addFile(File $file): self
    {
        if (!\in_array($file, $this->files, true)) {
            $this->files[] = $file;
        }

        return $this;
    }

    public function isArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'config' => $this->config,
            'members' => \array_map(function ($member) {
                return $member->toArray();
            }, $this->members),
        ];
    }
}
