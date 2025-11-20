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
    function createFraisForfait(Request $request, SerializerInterface $unSerialiseur, EntityManagerInterface $em, URLGeneratorInterface $unUrlGenerateur)
    {
        $contenu = $request->getContent();
        $unFraisForfait = $unSerialiseur->deserialize($contenu, FraisForfait::class, 'json');
        $em->persist($unFraisForfait);
        $em->flush();

        $location = $unUrlGenerateur->generate('fraisforfaits_post', 
                                ['id' => $unFraisForfait->getId()],
                                UrlGeneratorInterface::ABSOLUTE_URL);

        $result = ["message" => "Nouveau frais forfait créé"];
        return new JsonResponse($result, JSONResponse::HTTP_CREATED, [], false);
    }
}
