<?php

namespace App\Tests;

use App\Entity\Role;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use App\Entity\Visiteur;

class VisiteurTest extends KernelTestCase
{
    /**
     * Invoque les règles de validation sur un objet Visiteur construit à partir de $uneVille,
     * $unCP et vérifie que le résultat de la validation est $isOk
     * @param string $uneVille
     * @param string $unCp
     * @param bool $estValide
     * @return void aucun résultat
     */
    #[Test]
    #[DataProvider("validationVisiteurProvider")]
    public function validationVisiteur(string $uneVille, string $unCp, bool $estValide): void
    {
        $kernel = self::bootKernel();
        $unValidateur = static::getContainer()->get('validator');
        $unVisiteur = new Visiteur();
        $unVisiteur->setId('a55')->setVille($uneVille)->setCp($unCp);
        $collErreurs = $unValidateur->validate($unVisiteur);
        self::assertEquals($estValide, $collErreurs->count() === 0);
    }
    /**
     * Fournit les cas de test pour la méthode validationVisiteur :
     * ciblant indépendamment chaque propriété, ville et code postal, puis plusieurs à la fois
     * Retourne un tableau des cas de test, chaque cas de test correspondant à un n-uplet 
     * d'arguments ville, codePostal, estValide
     * @return array tableau des cas de test
     */
    public static function validationVisiteurProvider() : array {
        return [ "Visiteur avec valeurs correctes" => ["Chateaugiron", "35410", true],
                 "Visiteur avec ville non renseignée" => ["", "11999", false],
                 "Visiteur avec cp non renseignée" => ["Chateaugiron", "", false],
                 "Visiteur avec cp & ville non renseignée" => ["", "", false],
             ];
    }

    /**
     * Un seul cas de test ici car on vérifie que c'est bien le login 
     * qui est renvoyé comme id, donc pas besoin de fournisseur de données
     */
    #[Test]
    public function getUserIdentifier(): void
    {
        $unVisiteur = new Visiteur();
        $unVisiteur->setLogin('dandre')
                    ->setNom('David')
                    ->setPrenom('André')
                    ->setMdp('passe');
        
        self::assertEquals('dandre', $unVisiteur->getUserIdentifier(), "Le login doit être retourné");
    }

    /**
     * Un seul cas de test ici car on vérifie que c'est bien le login 
     * qui est renvoyé comme id, donc pas besoin de fournisseur de données
     */
    #[Test]
    public function getPassword(): void
    {
        $unVisiteur = new Visiteur();
        $unVisiteur->setLogin('dandre')
                    ->setNom('David')
                    ->setPrenom('André')
                    ->setMdp('passe');
        
        self::assertEquals('passe', $unVisiteur->getPassword(), "Le mdp doit être retourné");
    }

    /**
     * Un seul cas de test ici car on vérifie que c'est bien le login 
     * qui est renvoyé comme id, donc pas besoin de fournisseur de données
     */
    #[Test]
    public function getRoles(): void
    {
        $unVisiteur = new Visiteur();
        $unRole = new Role();
        $unVisiteur->setLogin('dandre')
                    ->setNom('David')
                    ->setPrenom('André')
                    ->setMdp('passe')
                    ->addRoleUtilisateur($unRole->setLibelle('ROLE_VISITEUR'));
        
        self::assertEquals(['ROLE_VISITEUR'], $unVisiteur->getRoles(), "Le rôle doit être retourné");
    }

}