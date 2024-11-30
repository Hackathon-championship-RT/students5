<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\TileTypeDto;
use App\Entity\TileType;
use App\Repository\TileTypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\HttpKernel\Attribute\MapUploadedFile;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints as Assert;

class TileTypeController extends AbstractController
{
    #[Route('/admin', name: 'app_tile_type')]
    public function index(): Response
    {
        return $this->render('pages/index.html.twig', [
            'controller_name' => 'TileTypeController',
        ]);
    }

    #[Route('/api/tile-types', name: 'api_get_tile_types', methods: ['GET'], format: 'json')]
    public function show(TileTypeRepository $tileTypeRepository): JsonResponse
    {
        $tileTypes = $tileTypeRepository->findAll();
        return $this->json($tileTypes);
    }

    #[Route('/api/tile-types/{id}', name: 'api_get_tile_type', methods: ['GET'], format: 'json')]
    public function showOne(TileType $tileType): JsonResponse
    {
        return $this->json($tileType);
    }

    #[Route('/api/tile-types', name: 'api_create_tile_type', methods: ['POST'], format: 'json')]
    public function create(#[MapRequestPayload] TileTypeDto $tileTypeDto, EntityManagerInterface $entityManager): JsonResponse
    {
        $tileType = new TileType();
        $tileType->setName($tileTypeDto->name);
        $tileType->setDescription($tileTypeDto->description);
        $tileType->setCategory($tileTypeDto->category);
        $tileType->setCountry($tileTypeDto->country);

        $entityManager->persist($tileType);
        $entityManager->flush();

        return $this->json($tileType, Response::HTTP_CREATED);
    }

    #[Route('/api/tile-types/{id}', name: 'api_edit_tile_type', methods: ['PUT'], format: 'json')]
    public function edit(TileType $tileType, #[MapRequestPayload] TileTypeDto $tileTypeDto, EntityManagerInterface $entityManager): JsonResponse
    {
        $tileType->setName($tileTypeDto->name);
        $tileType->setDescription($tileTypeDto->description);
        $tileType->setCategory($tileTypeDto->category);
        $tileType->setCountry($tileTypeDto->country);

        $entityManager->flush();

        return $this->json($tileType);
    }

    #[Route('/api/tile-types/{id}', name: 'api_delete_tile_type', methods: ['DELETE'], format: 'json')]
    public function delete(TileType $tileType, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($tileType);
        $entityManager->flush();

        return $this->json(null, Response::HTTP_NO_CONTENT);
    }

    #[Route(
        '/tile-types/{id}/cover',
        name: 'tile_cover',
        requirements: ['id' => '\d+'],
        methods: ['POST'],
        format: 'json'
    )]
    public function uploadCover(
        TileType               $tileType,
        #[MapUploadedFile([
            new Assert\File(mimeTypes: ['image/png', 'image/jpeg']),
            new Assert\Image(maxWidth: 3840, maxHeight: 2160)
        ])]
        UploadedFile           $cover,
        EntityManagerInterface $entityManager
    ): JsonResponse
    {
        $dir = $this->getParameter('kernel.project_dir') . '/public/uploads';
        $originalFilename = pathinfo($cover->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = $originalFilename . mt_rand() . '.' . $cover->guessExtension();
        $cover->move(
            $dir,
            $filename
        );

        $tileType->setImagePath($filename);
        $entityManager->flush();

        return $this->json($tileType);
    }
}
