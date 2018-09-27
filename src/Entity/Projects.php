<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProjectsRepository")
 */
class Projects
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name_pr;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc_project;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name_proj;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNamePr(): ?string
    {
        return $this->name_pr;
    }

    public function setNamePr(?string $name_pr): self
    {
        $this->name_pr = $name_pr;

        return $this;
    }

    public function getDescProject(): ?string
    {
        return $this->desc_project;
    }

    public function setDescProject(?string $desc_project): self
    {
        $this->desc_project = $desc_project;

        return $this;
    }

    public function getNameProj(): ?string
    {
        return $this->name_proj;
    }

    public function setNameProj(?string $name_proj): self
    {
        $this->name_proj = $name_proj;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
}
