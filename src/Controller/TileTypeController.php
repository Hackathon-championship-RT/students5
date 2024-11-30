<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\TileType;
use App\Repository\TileTypeRepository;
use App\Dto\TileTypeDto;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

class TileTypeController extends AbstractController
{
    #[Route('/tile-type', name: 'app_tile_type')]
    public function index(): Response
    {
        return $this->render('tile_type/index.html.twig', [
            'controller_name' => 'TileTypeController',
        ]);
    }

    #[Route('/api/tile-types', name: 'api_get_tile_types', format: 'json', methods: ['GET'])]
    public function show(TileTypeRepository $tileTypeRepository): JsonResponse
    {
        $tileTypes = $tileTypeRepository->findAll();
        return $this->json($tileTypes);
    }

    #[Route('/api/tile-types/{id}', name: 'api_get_tile_type', format: 'json', methods: ['GET'])]
    public function showOne(TileType $tileType): JsonResponse
    {
        return $this->json($tileType);
    }

    #[Route('/api/tile-types', name: 'api_create_tile_type', format: 'json', methods: ['POST'])]
    public function create(#[MapRequestPayload] TileTypeDto $tileTypeDto, EntityManagerInterface $entityManager): JsonResponse
    {
        $tileType = new TileType();
        $tileType->setName($tileTypeDto->name);
        $tileType->setImagePath($tileTypeDto->imagePath);
        $tileType->setDescription($tileTypeDto->description);
        $tileType->setCategory($tileTypeDto->category);
        $tileType->setCountry($tileTypeDto->country);

        $entityManager->persist($tileType);
        $entityManager->flush();

        return $this->json($tileType, JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/tile-types/{id}', name: 'api_edit_tile_type', format: 'json', methods: ['PUT'])]
    public function edit(TileType $tileType, #[MapRequestPayload] TileTypeDto $tileTypeDto, EntityManagerInterface $entityManager): JsonResponse
    {
        $tileType->setName($tileTypeDto->name);
        $tileType->setImagePath($tileTypeDto->imagePath);
        $tileType->setDescription($tileTypeDto->description);
        $tileType->setCategory($tileTypeDto->category);
        $tileType->setCountry($tileTypeDto->country);

        $entityManager->flush();

        return $this->json($tileType);
    }

    #[Route('/api/tile-types/{id}', name: 'api_delete_tile_type', format: 'json', methods: ['DELETE'])]
    public function delete(TileType $tileType, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($tileType);
        $entityManager->flush();

        return $this->json(null, JsonResponse::HTTP_NO_CONTENT);
    }
}
