<?php

namespace App\Twig;

use App\Entity\Train;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TrainMenuFilter extends AbstractExtension
{
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        /** @var @var EntityManagerInterface manager */
        $this->manager = $manager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getTrainMenu', [$this, 'getTrainMenu']),
        ];
    }

    public function getTrainMenu(): ?array
    {

        return $this->manager->getRepository(Train::class)->findAll();
    }
}