<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Process\Process;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Filesystem\Filesystem;

class CacheController extends AbstractController
{
    #[Route('/cache/clear', name: 'cache_clear')]
    public function clearCache(
        LoggerInterface $logger,
        ParameterBagInterface $params
    ): Response
    {        
        // Utiliser le chemin spécifique à OVH pour PHP 8.3
        $phpBinary = '/usr/local/php8.3/bin/php';
        
        // Supprimer manuellement le répertoire de cache
        $cacheDir = $params->get('kernel.project_dir') . '/var/cache/prod';
        $filesystem = new Filesystem();

        try {
            // Supprimer le répertoire de cache s'il existe
            if ($filesystem->exists($cacheDir)) {
                $process1 = new Process(['rm', '-rf', $cacheDir]);
                $process1->mustRun();
            }
            
            // Exécuter la commande cache:clear
            $process2 = new Process([
                $phpBinary, 
                $params->get('kernel.project_dir') . '/bin/console', 
                'cache:clear', 
                '--no-warmup'
            ]);
            $process2->mustRun();
            
            $logger->info('Cache vidé manuellement par un administrateur');
            $this->addFlash('success', 'Le cache a été vidé avec succès.');
        } catch (\Exception $exception) {
            $logger->error('Erreur lors du vidage du cache: ' . $exception->getMessage());
            $this->addFlash('error', 'Une erreur est survenue lors du vidage du cache: ' . $exception->getMessage());
        }

        // Rediriger vers la page précédente ou le tableau de bord
        return $this->redirectToRoute('home');
    }
} 