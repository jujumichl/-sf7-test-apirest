<?php
namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use App\Entity\FraisForfait;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class FraisForfaitTest extends KernelTestCase
{
    #[Test]
    public function validationFFAvecIdTropLong(): void
    {
        $kernel = self::bootKernel();
        $unValidateur = static::getContainer()->get('validator');
        $unFF = new FraisForfait();
        $unFF->setId("ABCD")->setLibelle("libelle")->setMontant("500");
        $collErreurs = $unValidateur->validate($unFF);
        self::assertTrue($collErreurs->count() > 0);
    }
    /**
     * Invoque les règles de validation sur un objet FraisForfait construit à partir de $unId, $unLibelle,
     * $unMontant et vérifie que le résultat de la validation est $isOk
     * @param string $unId
     * @param string $unLibelle
     * @param string $unMontant
     * @param bool $isOk
     * @return void aucun résultat
     */
    #[Test]
    #[DataProvider("validationFFProvider")]
    public function validationFF(string $unId, string $unLibelle, string $unMontant, bool $estValide): void
    {
        $kernel = self::bootKernel();
        $unValidateur = static::getContainer()->get('validator');
        $unFF = new FraisForfait();
        $unFF->setId($unId)->setLibelle($unLibelle)->setMontant($unMontant);
        $collErreurs = $unValidateur->validate($unFF);
        self::assertEquals($estValide, $collErreurs->count() === 0);
    }
    /**
     * Fournit les cas de test pour la méthode validationFF :
     * ciblant indépendamment chaque propriété, id, libelle, montant, puis plusieurs à la fois
     * Retourne un tableau des cas de test, chaque cas de test correspondant à un n-uplet 
     * d'arguments id, libelle, montant, estValide
     * @return array tableau des cas de test
     */
    public static function validationFFProvider() : array {
        return [ "FF avec valeurs correctes et mêmes majuscules" => ["XXX", "libelle", "250", true],
                 "FF avec valeurs correctes et majuscules différentes" => ["AKZ", "libelle", "250", true],
                 "FF avec id non renseigné" => ["", "libelle", "250", false],
                 "FF avec id trop long" => ["ABCD", "libelle", "250", false],
                 "FF avec id comportant 1 minuscule" => ["XRt", "libelle", "250", false],
                 "FF avec id comportant 3 caractères autres que maj" => ["$9m", "libelle", "250", false],
            ];
    }
}