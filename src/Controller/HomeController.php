<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TeamRepository;
use App\Repository\BannerRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TeamRepository $teamRepository, BannerRepository $bannerRepository): Response
    {
        $teams = $teamRepository->findAll();
        $banner = $bannerRepository->findAll();
        return $this->render('home/index.html.twig', [
            'teams' => $teams,
            'banner' => $banner[0] ?? null,
        ]);
    }
}
