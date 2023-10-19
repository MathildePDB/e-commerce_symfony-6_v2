<?php

namespace App\Service;

use App\Entity\Categories;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class CategoriesService extends AbstractExtension
{
    public function __construct(
        protected readonly EntityManagerInterface $entityManagerInterface
    ) {}
    
    public function getFunctions(): array
    {
        return [
            new TwigFunction('myData', [$this, 'findMyData']),
        ];
    }

    public function findMyData(): array
    {
        return $this->entityManagerInterface->getRepository(Categories::class)->findBy(
            [], 
            ['categoryOrder' => 'asc']
        );
    }
}