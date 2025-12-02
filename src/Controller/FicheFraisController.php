<?php

namespace App\Controller;

use App\Repository\FicheFraisRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;


final class FicheFraisController extends AbstractController
{
    #[Route('/fichesfrais', name: 'fichefrais', methods: ['GET'])]
    public function index(FicheFraisRepository $uneFicheFraisRepository, SerializerInterface $unSerialiseur): JsonResponse
    {
        $lesFichesFrais = $uneFicheFraisRepository->findAll();
        $result = [
            'message' => 'OK',
            'data' => $lesFichesFrais
        ];
        $serializedResult = $unSerialiseur->serialize($result, 'json');
        return new JSONResponse($serializedResult, JsonResponse::HTTP_OK, [], true);
    }
}
