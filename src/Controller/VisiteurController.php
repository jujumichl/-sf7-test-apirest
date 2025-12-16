<?php

namespace App\Controller;

use App\Repository\VisiteurRepository;
use App\Entity\Visiteur;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Doctrine\ORM\EntityManagerInterface;

final class VisiteurController extends AbstractController
{
    #[Route('/visiteurs/{id}', name: 'visiteur_put', methods: ['PUT'])]
    public function modificationV(string $id, Request $request, VisiteurRepository $unVisiteurRepository, SerializerInterface $unSerialiseur, 
    EntityManagerInterface $em, ValidatorInterface $unValidator): JsonResponse{
        $contenu = $request->getContent();
        $unVisiteur = $unSerialiseur->deserialize($contenu, Visiteur::class, 'json');
        $objetExistant = $unVisiteurRepository->find($id);
        $errors = $unValidator->validate($unVisiteur);
        if ($errors->count() > 0){
            $messages = [];
            foreach ($errors as $error){
                $messages[] = [$error->getPropertyPath() => $error->getMessage()];
            }
            $result = ["message" => "Données erronées", "errors"=> $messages];
            
            return new JsonResponse($result, JsonResponse::HTTP_BAD_REQUEST, [], false);
        }
        //if ($this->dejaPresent($contenu, $unVisiteurRepository, $unSerialiseur)){
        if ($objetExistant !== null) {
            $unSerialiseur->deserialize($contenu, Visiteur::class, 'json',
       [
                    AbstractNormalizer::OBJECT_TO_POPULATE => $objetExistant,
                ]);
            $em->flush();

            $result = ["message" => "Visiteur d'id {$id} été modifié"];
            return new JsonResponse($result, JsonResponse::HTTP_OK, [], false);
        }
        else {
            $result = ["message" => "Visiteur inexistant"];
            return new JsonResponse($result, JsonResponse::HTTP_NOT_FOUND, [], false);
        }
    }
}
