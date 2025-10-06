<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Team;
use App\Form\TeamFormType;
use Symfony\Component\HttpFoundation\Request;

final class TeamController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
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
        }

        return $this->render('team/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
