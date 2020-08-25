<?php

namespace App\Entity;

use App\Repository\TicketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TicketRepository::class)
 */
class Ticket
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $priority;

    /**
     * @ORM\Column(type="datetime")
     */
    private $posted;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="ticket")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="ticket")
     */
    private $comments;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $agent_id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $escalated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $reopened;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $wont_fix;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->setStatus("open");
        $this->setPriority("low");
        $this->setPosted(new \DateTime());
        $this->setEscalated(false);
        $this->setReopened(false);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getPosted(): ?\DateTimeInterface
    {
        return $this->posted;
    }

    public function setPosted(\DateTimeInterface $posted): self
    {
        $this->posted = $posted;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTicket($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getTicket() === $this) {
                $comment->setTicket(null);
            }
        }

        return $this;
    }

    public function getAgentId(): ?int
    {
        return $this->agent_id;
    }

    public function setAgentId(?int $agent_id): self
    {
        $this->agent_id = $agent_id;

        return $this;
    }

    public function getEscalated(): ?bool
    {
        return $this->escalated;
    }

    public function setEscalated(bool $escalated): self
    {
        $this->escalated = $escalated;

        return $this;
    }

    public function getReopened(): ?bool
    {
        return $this->reopened;
    }

    public function setReopened(bool $reopened): self
    {
        $this->reopened = $reopened;

        return $this;
    }

    public function getWontFix(): ?string
    {
        return $this->wont_fix;
    }

    public function setWontFix(?string $wont_fix): self
    {
        $this->wont_fix = $wont_fix;

        return $this;
    }
}
