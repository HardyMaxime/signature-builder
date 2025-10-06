<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Team;
use App\Form\TeamFormType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\TeamRepository;
use App\Repository\BannerRepository;

final class TeamController extends AbstractController
{
    private $entityManager;
    private $teamRepository;
    private $bannerRepository;

    public function __construct(EntityManagerInterface $entityManager, TeamRepository $teamRepository, BannerRepository $bannerRepository)
    {
        $this->entityManager = $entityManager;
        $this->teamRepository = $teamRepository;
        $this->bannerRepository = $bannerRepository;
    }

    #[Route('/equipe/ajouter', name: 'team_add')]
    public function add(Request $request): Response
    { 
        $team = new Team();
        $form = $this->createForm(TeamFormType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($team);
            $this->entityManager->flush();
            $this->addFlash('success', 'Personnel ajouté avec succès');
            return $this->redirectToRoute('home');
        }

        return $this->render('team/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/equipe/signature/{id}', name: 'team_signature', requirements: ['id' => '\d+'])]
    public function signature(int $id): Response
    {
        $team = $this->teamRepository->find($id);
        $banner = $this->bannerRepository->findAll();

        return $this->render('team/signature.html.twig', [
            'team' => $team,
            'banner' => $banner[0] ?? null,
        ]);
    }

    #[Route('/equipe/supprimer/{id}', name: 'team_delete', requirements: ['id' => '\d+'])]
    public function delete(int $id, Request $request): Response
    {
        if(!$this->isCsrfTokenValid('team_delete', $request->request->get('token'))) {
            $this->addFlash('error', 'Token invalide');
            return $this->redirectToRoute('home');
        }

        $team = $this->teamRepository->find($id);
        $this->entityManager->remove($team);
        $this->entityManager->flush();
        $this->addFlash('success', 'Personnel supprimé avec succès');
        return $this->redirectToRoute('home');
    }
}
