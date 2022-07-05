<?php

namespace App\Entity;

use App\Repository\ChatbotMessagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatbotMessagesRepository::class)
 */
class ChatbotMessages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1000)
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=Chatbot::class, inversedBy="chatbotMessages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chatbot_id;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getChatbotId(): ?Chatbot
    {
        return $this->chatbot_id;
    }

    public function setChatbotId($chatbot_id): self
    {
        $this->chatbot_id = $chatbot_id;

        return $this;
    }

    public function __toString(): string{
        return $this->message;
    }

}
