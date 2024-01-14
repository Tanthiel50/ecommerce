<?php

namespace App\Controller;

use App\Service\PromotionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GlobalController extends AbstractController
{
    private $promotionService;

    public function __construct(PromotionService $promotionService)
    {
        $this->promotionService = $promotionService;
    }

    public function promotion()
    {
        $promotion = $this->promotionService->getCurrentPromotion();
        return $this->render('partials/promotion.html.twig', [
            'promotion' => $promotion
        ]);
    }
}
