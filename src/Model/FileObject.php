<?php

declare(strict_types=1);

namespace Wdhaoui\Yousign\Model;

class FileObject extends BaseModel
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var File
     */
    protected $file;

    /**
     * @var int
     */
    protected $page = 1;

    /**
     * @var string
     */
    protected $position;

    /**
     * @var string
     */
    protected $fieldName;

    /**
     * @var string
     */
    protected $mention;

    /**
     * @var string
     */
    protected $mention2;

    /**
     * @var \DateTimeInterface
     */
    protected $createdAt;

    /**
     * @var \DateTimeInterface
     */
    protected $updatedAt;

    protected $subObjects = [
        'file' => File::class,
    ];

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getPosition(): ?string
    {
        return $this->position;
    }

    public function setPosition(string $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getFieldName(): ?string
    {
        return $this->fieldName;
    }

    public function setFieldName(string $fieldName): self
    {
        $this->fieldName = $fieldName;

        return $this;
    }

    public function getMention(): ?string
    {
        return $this->mention;
    }

    public function setMention(string $mention): self
    {
        $this->mention = $mention;

        return $this;
    }

    public function getMention2(): ?string
    {
        return $this->mention2;
    }

    public function setMention2(string $mention2): self
    {
        $this->mention2 = $mention2;

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

    public function toArray()
    {
        return [
            'file' => ($this->file) ? $this->file->getId() : null,
            'page' => $this->page,
            'position' => $this->position,
            'mention' => $this->mention,
            'mention2' => $this->mention2,
        ];
    }
}
