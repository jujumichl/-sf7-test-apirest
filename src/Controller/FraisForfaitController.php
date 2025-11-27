<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\FraisForfaitRepository;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\FraisForfait;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class FraisForfaitController extends AbstractController
{
    #[Route('/fraisforfaits', name: 'fraisforfaits_get', methods: ['GET'])]
    public function index(FraisForfaitRepository $unFraisForfaitRepository, SerializerInterface $unSerialiseur): JsonResponse
    {
        $lesFraisForfaits = $unFraisForfaitRepository->findAll();
        $result = [
            'message' => 'OK',
            'data' => $lesFraisForfaits
        ];
        $serializedResult = $unSerialiseur->serialize($result, 'json');
        return new JSONResponse($serializedResult, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/fraisforfaits/{id}', name: 'fraisforfaits_get_id', methods: ['GET'])]
    public function getDetailFraisForfait(string $id, FraisForfaitRepository $unFraisForfaitRepository, SerializerInterface $unSerialiseur): JsonResponse
    {
        $unFraisForfait = $unFraisForfaitRepository->find($id);
        if ($unFraisForfait === null) {
            return new JSONResponse(['message' => 'Id frais forfait inexistant'], JsonResponse::HTTP_NOT_FOUND);
        }
        $result = [
            'message' => 'Frais forfait demandé',
            'data' => $unFraisForfait
        ];
        $serializedResult = $unSerialiseur->serialize($result, 'json');

        return new JSONResponse($serializedResult, JsonResponse::HTTP_OK, [], true);
    }

    #[Route('/fraisforfaits', name: 'fraisforfaits_post', methods: ['POST'])]
    public function createFraisForfait(Request $request,FraisForfaitRepository $unFraisForfaitRepository, SerializerInterface $unSerialiseur,
    EntityManagerInterface $em, URLGeneratorInterface $unUrlGenerateur)
    {
        $contenu = $request->getContent();
        $unFraisForfait = $unSerialiseur->deserialize($contenu, FraisForfait::class, 'json');
        $em->persist($unFraisForfait);
        $id = $unFraisForfait->getId();
        $dejaPresent = $unFraisForfaitRepository->find($id);
        //if ($this->dejaPresent($contenu, $unFraisForfaitRepository, $unSerialiseur)){
        if ($dejaPresent === null) {
            $em->flush();
                $location = $unUrlGenerateur->generate('fraisforfaits_post', 
                                        ['id' => $unFraisForfait->getId()],
                                        UrlGeneratorInterface::ABSOLUTE_URL);

                $result = ["message" => "Nouveau frais forfait créé",
                        "data" => [
                            "_selfLink" => $location
                            ]
                        ];
                return new JsonResponse($result, JSONResponse::HTTP_CREATED, [], false);
        }
        else {
            $result = ["message" => "Id frais forfait déjà existant"];
            return new JsonResponse($result, JSONResponse::HTTP_CONFLICT, [], false);
        }
    }

    /**
     * Renvoie un booleen en fonction de si l'id est dékà implémenter dans la bdd
     * @param string $contenu le contenue récupérer de la requête
     * @param FraisForfaitRepository $unFraisForfaitRepository
     * @param SerializerInterface $unSerialiseur
     * @return bool Renvoie true si l'id est déjà present, sinon false
     */
    /* private function dejaPresent(string $contenu, FraisForfaitRepository $unFraisForfaitRepository, SerializerInterface $unSerialiseur): bool{
        $idStart = 10; // a l'entrée de la guillemet
        $idEnd = strpos($contenu, ',') - 1; // position avant la guillemet
        $allFF = $this->getDetailFraisForfait(substr($contenu, $idStart, $idEnd - $idStart), $unFraisForfaitRepository, $unSerialiseur);
        $rep = json_decode($allFF->getContent(), true);
        if ($rep['message'] === 'Id frais forfait inexistant'){
            return true;
        }
        else{
            return false;
        }
    } */

    #[Route('/fraisforfaits/{id}', name: 'fraisforfaits_put', methods: ['PUT'])]
    public function modificationFF(string $id, Request $request, FraisForfaitRepository $unFraisForfaitRepository, SerializerInterface $unSerialiseur, 
    EntityManagerInterface $em, URLGeneratorInterface $unUrlGenerateur): JsonResponse{
        $contenu = $request->getContent();
        $objetExistant = $unFraisForfaitRepository->find($id);
        
        //if ($this->dejaPresent($contenu, $unFraisForfaitRepository, $unSerialiseur)){
        if ($objetExistant !== null) {
            $unFraisForfait = $unSerialiseur->deserialize($contenu, FraisForfait::class, 'json');
            $libelle = $unFraisForfait->getLibelle();
            $montant = $unFraisForfait->getMontant();
            $objetExistant->setMontant($montant);
            $objetExistant->setLibelle($libelle);
            $em->flush();
            $location = $unUrlGenerateur->generate('fraisforfaits_put', 
                                    ['id' => $id],
                                    UrlGeneratorInterface::ABSOLUTE_URL);

            $result = ["message" => "Frais forfait modifié",
                    "data" => [
                        "_selfLink" => $location
                        ]
                    ];
            return new JsonResponse($result, JSONResponse::HTTP_OK, [], false);
        }
        else {
            $result = ["message" => "Id frais forfait inexistant"];
            return new JsonResponse($result, JSONResponse::HTTP_NOT_MODIFIED, [], false);
        }
    }
}
