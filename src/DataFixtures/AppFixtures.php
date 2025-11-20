<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\FraisForfait;
use Doctrine\DBAL\Types\DecimalType;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        /* $unFraisForfaitETP = new FraisForfait();
        $unFraisForfaitETP->setId('ETP');
        $unFraisForfaitETP->setLibelle('Forfait Etape');
        $unFraisForfaitETP->setMontant(110);
        $manager->persist($unFraisForfaitETP);

        $unFraisForfaitKM = new FraisForfait();
        $unFraisForfaitKM->setId('KM');
        $unFraisForfaitKM->setLibelle('Forfait Kilométrique');
        $unFraisForfaitKM->setMontant(0.62);
        $manager->persist($unFraisForfaitKM);

        $unFraisForfaitREP = new FraisForfait();
        $unFraisForfaitREP->setId('REP');
        $unFraisForfaitREP->setLibelle('Forfait Repas Restaurant');
        $unFraisForfaitREP->setMontant(25.00);
        $manager->persist($unFraisForfaitREP);

        $unFraisForfaitNUI = new FraisForfait();
        $unFraisForfaitNUI->setId('NUI');
        $unFraisForfaitNUI->setLibelle('Forfait Nuitée Hôtel');
        $unFraisForfaitNUI->setMontant(25.00); */
        $unFraisForfait = $this->setNewObject('ETP', 'Forfait Etape', 110, $manager);
        $unFraisForfait = $this->setNewObject('KM', 'Forfait Kilométrique', 0.62, $manager);
        $unFraisForfait = $this->setNewObject('REP', 'Forfait Repas Restaurant', 80.00, $manager);
        $unFraisForfait = $this->setNewObject('NUI', 'Forfait Nuitée Hôtel', 25.00, $manager);

        $manager->flush();
    }

    public function setNewObject(string $id, string $libelle, float $montant, ObjectManager $manager): bool{
        $unFraisForfait = new FraisForfait();
        $unFraisForfait->setId($id);
        $unFraisForfait->setLibelle($libelle);
        $unFraisForfait->setMontant($montant);
        try{
            $manager->persist($unFraisForfait); // rend persistant dans l'ORM
        }
        catch(\Exception $e){
            echo $e->getMessage();
            return false;
        }
        return true;
    }
}
