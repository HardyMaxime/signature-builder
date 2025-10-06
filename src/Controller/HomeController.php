<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamFormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\TeamRepository;
use App\Repository\BannerRepository;
use App\Repository\LogoRepository;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TeamRepository $teamRepository, BannerRepository $bannerRepository, LogoRepository $logoRepository): Response
    {
        $teams = $teamRepository->findAll();
        $banner = $bannerRepository->findAll();
        $logo = $logoRepository->findAll();

        return $this->render('home/index.html.twig', [
            'teams' => $teams,
            'banner' => $banner[0] ?? null,
            'logo' => $logo[0] ?? null,
        ]);
    }
}
