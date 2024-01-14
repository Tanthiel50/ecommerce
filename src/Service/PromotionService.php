<?php

namespace App\Service;

use App\Repository\SalesRepository;
use Doctrine\ORM\EntityManagerInterface;

class PromotionService
{
    private $salesRepository;

    public function __construct(SalesRepository $salesRepository)
    {
        $this->salesRepository = $salesRepository;
    }

    public function getCurrentPromotion()
{
    $currentDate = new \DateTime();

    return $this->salesRepository->createQueryBuilder('s')
        ->where('s.date_begin <= :currentDate')
        ->andWhere('s.date_end >= :currentDate')
        ->setParameter('currentDate', $currentDate)
        ->setMaxResults(1)
        ->getQuery()
        ->getOneOrNullResult();
}
}
