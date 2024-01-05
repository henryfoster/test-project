<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\FoodType;
use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodController extends AbstractController
{
    #[Route('/food', name: 'app_food')]
    public function index(Request $request, FoodRepository $foodRepository): Response
    {
        $foundFood = new Food();
        $form = $this->createForm(FoodType::class, $foundFood);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('info', 'You found food!'. $foundFood->getName() );
        }

        $foods = $foodRepository->findAll();

        return $this->render('food/index.html.twig', [
            'controller_name' => 'FoodController',
            'form' => $form->createView(),
            'foods' => $foods
        ]);
    }
}
