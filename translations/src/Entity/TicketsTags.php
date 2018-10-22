<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TicketsTagsRepository")
 */
class TicketsTags
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $ticket_id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tag_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTicketId(): ?int
    {
        return $this->ticket_id;
    }

    public function setTicketId(?int $ticket_id): self
    {
        $this->ticket_id = $ticket_id;

        return $this;
    }

    public function getTagId(): ?int
    {
        return $this->tag_id;
    }

    public function setTagId(?int $tag_id): self
    {
        $this->tag_id = $tag_id;

        return $this;
    }
}
