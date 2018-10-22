<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketsRepository")
 */
class Tickets
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\Column(type="integer")
     */
    private $assigned_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $project_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $creater_id;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAssignedId(): ?int
    {
        return $this->assigned_id;
    }

    public function setAssignedId(int $assigned_id): self
    {
        $this->assigned_id = $assigned_id;

        return $this;
    }

    public function getProjectId(): ?int
    {
        return $this->project_id;
    }

    public function setProjectId(int $project_id): self
    {
        $this->project_id = $project_id;

        return $this;
    }

    public function getCreaterId(): ?int
    {
        return $this->creater_id;
    }

    public function setCreaterId(int $creater_id): self
    {
        $this->creater_id = $creater_id;

        return $this;
    }
    /**
    * @ORM\Column(type="string")
    *
    *
    *
    */
   private $brochure;

   public function getBrochure()
   {
       return $this->brochure;
   }

   public function setBrochure($brochure)
   {
       $this->brochure = $brochure;

       return $this;
   }
}
