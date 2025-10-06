<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Logo;
use App\Form\LogoFormType;

final class LogoController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/logo/ajouter', name: 'logo_add')]
    public function index(Request $request): Response
    {
        $logo = $this->entityManager->getRepository(Logo::class)->findLast() ?? new Logo();
        $form = $this->createForm(LogoFormType::class, $logo);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($logo);
            $this->entityManager->flush();
            $this->addFlash('success', 'Logo ajouté avec succès');
            return $this->redirectToRoute('home');
        }

        return $this->render('logo/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/logo/supprimer', name: 'logo_remove')]
    public function remove(Request $request): Response
    {
        if(!$this->isCsrfTokenValid('logo_remove', $request->request->get('token'))) {
            $this->addFlash('error', 'Token invalide');
            return $this->redirectToRoute('home');
        }

        $id = $request->request->get('id');
        $logo = $this->entityManager->getRepository(Logo::class)->find($id);
        $this->entityManager->remove($logo);
        $this->entityManager->flush();
        $this->addFlash('success', 'Logo supprimé avec succès');
        return $this->redirectToRoute('home');
    }
}
