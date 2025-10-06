<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TeamRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();
        return $this->render('home/index.html.twig', [
            'teams' => $teams,
        ]);
    }
}
