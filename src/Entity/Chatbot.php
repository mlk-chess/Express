<?php

namespace App\Entity;

use App\Repository\ChatbotRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatbotRepository::class)
 */
class Chatbot
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $client_name;

    /**
     * @ORM\Column(type="integer")
     */
    private $client_problem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $client_email;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=ChatbotMessages::class, mappedBy="chatbot_id")
     */
    private $chatbotMessages;

    public function __construct()
    {
        $this->chatbotMessages = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClientName(): ?string
    {
        return $this->client_name;
    }

    public function setClientName(string $client_name): self
    {
        $this->client_name = $client_name;

        return $this;
    }

    public function getClientProblem(): ?int
    {
        return $this->client_problem;
    }

    public function setClientProblem(int $client_problem): self
    {
        $this->client_problem = $client_problem;

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

    public function getClientEmail(): ?string
    {
        return $this->client_email;
    }

    public function setClientEmail(string $client_email): self
    {
        $this->client_email = $client_email;

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

    /**
     * @return Collection<int, ChatbotMessages>
     */
    public function getChatbotMessages(): Collection
    {
        return $this->chatbotMessages;
    }

    public function addChatbotMessage(ChatbotMessages $chatbotMessage): self
    {
        if (!$this->chatbotMessages->contains($chatbotMessage)) {
            $this->chatbotMessages[] = $chatbotMessage;
            $chatbotMessage->setChatbotId($this);
        }

        return $this;
    }

    public function removeChatbotMessage(ChatbotMessages $chatbotMessage): self
    {
        if ($this->chatbotMessages->removeElement($chatbotMessage)) {
            // set the owning side to null (unless already changed)
            if ($chatbotMessage->getChatbotId() === $this) {
                $chatbotMessage->setChatbotId(null);
            }
        }

        return $this;
    }

    public function __toString(): string{
        return $this->client_name;
    }
}
