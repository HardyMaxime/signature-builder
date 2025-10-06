<?php

namespace App\DataFixtures;

use App\Entity\Team;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PersonnelFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $personnels = [
            [
                "nom" => "GEAY",
                "prenom" => "Ingrid",
                "titre" => "Co-directrice",
                "telephone" => "07 49 57 94 96",
                "role" => "Créatrice d'avenir",
                "email" => "i.geay@efra.fr",
            ],
            [
                "nom" => "MOREAUX",
                "prenom" => "Véronique",
                "titre" => "Co-directrice",
                "telephone" => "07 49 66 11 61",
                "role" => "Créatrice d'avenir",
                "email" => "v.moreaux@efra.fr",
            ],
            [
                "nom" => "OLIVEIRA",
                "prenom" => "José",
                "titre" => "Directeur opérationnel",
                "telephone" => "03 26 07 22 50",
                "email" => "j.oliveira@efra.fr",
            ],
            [
                "nom" => "GRIMEAU",
                "prenom" => "Malika",
                "titre" => "Assistante",
                "telephone" => "03 26 07 22 50",
                "role" => "Business manager",
                "email" => "m.grimeau@efra.fr",
            ],
            [
                "nom" => "KARL",
                "prenom" => "Melissa",
                "titre" => "Assistante",
                "telephone" => "03 25 42 84 89",
                "role" => "Business manager",
                "email" => "m.karl@efra.fr",
            ],
            [
                "nom" => "LIGNEY",
                "prenom" => "Anaïs",
                "titre" => "Service relations entreprises",
                "telephone" => "07 49 01 48 76",
                "email" => "troyes@efra.fr",
            ],
            [
                "nom" => "BOTTAN",
                "prenom" => "Camille",
                "titre" => "Service pédagogique",
                "telephone" => "03 26 07 22 50",
                "email" => "adiministration@efra.fr",
            ],
        ];

        foreach ($personnels as $data) {
            $personnel = new Team();
            $personnel->setLastName($data['nom']);
            $personnel->setFirstName($data['prenom']);
            $personnel->setTitle($data['titre']);
            $personnel->setPhone($data['telephone']);
            $personnel->setEmail($data['email']);

            if (isset($data['role'])) {
                $personnel->setRole($data['role']);
            }

            $manager->persist($personnel);
        }

        $manager->flush();
    }
}
