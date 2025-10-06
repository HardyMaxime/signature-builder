<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Banner;
use App\Form\BannerFormType;

final class BannerController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/banner', name: 'banner_add')]
    public function index(Request $request): Response
    {

        if($this->entityManager->getRepository(Banner::class)->findAll()) {
            $this->addFlash('error', 'Une bannière existe déjà, vous ne pouvez en ajouter qu\'une seule.');
            return $this->redirectToRoute('home');
        }

        $banner = new Banner();
        $form = $this->createForm(BannerFormType::class, $banner);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($banner);
            $this->entityManager->flush();
            $this->addFlash('success', 'Bannière ajoutée avec succès');
            return $this->redirectToRoute('home');
        }

        return $this->render('banner/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/banner/remove', name: 'banner_remove')]
    public function remove(Request $request): Response
    {
        if(!$this->isCsrfTokenValid('banner_remove', $request->request->get('token'))) {
            $this->addFlash('error', 'Token invalide');
            return $this->redirectToRoute('home');
        }

        $id = $request->request->get('id');
        $banner = $this->entityManager->getRepository(Banner::class)->find($id);
        $this->entityManager->remove($banner);
        $this->entityManager->flush();
        $this->addFlash('success', 'Bannière supprimée avec succès');
        return $this->redirectToRoute('home');
    }
}
