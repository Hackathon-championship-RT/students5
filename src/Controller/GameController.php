<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\UserDto;
use App\Entity\Game;
use App\Entity\Turn;
use App\Helper\BoardHelper;
use App\Helper\Tile;
use App\Repository\GameRepository;
use App\Repository\TurnRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class GameController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TurnRepository         $turnRepository,
        private readonly GameRepository         $gameRepository,
    )
    {
    }

    #[Route(
        '/game',
        name: 'game_start',
        methods: ['POST'],
        format: 'json'
    )]
    public function startGame(#[MapRequestPayload] UserDto $userDto): JsonResponse
    {
        $game = new Game();
        $game->setUserUuid($userDto->userUuid);
        $game->setStartTime(new \DateTime());
        $this->entityManager->persist($game);
        $this->entityManager->flush();
        return $this->json(['board' => BoardHelper::generateBoard(), 'game' => $game]);
    }

    #[Route('/game/{id}/turn', name: 'turn', format: 'json')]
    public function getCurrentTurn(Game $game): JsonResponse
    {
        // send info from current turn
        return $this->json($this->turnRepository->findLastTurn($game));
    }

    #[Route('/game/continue', name: 'continue_game', format: 'json')]
    public function continuePlaying(#[MapRequestPayload] UserDto $userDto): JsonResponse
    {
        // send info from current turn
        return $this->json($this->gameRepository->findLastGame($userDto->userUuid));
    }

    #[Route('/game/{id}/match', name: 'match', format: 'json')]
    public function matchTiles(Request $request, Game $game): JsonResponse
    {
        $rawData = json_decode($request->getContent(), true);
        $output = array_map(fn($el) => (new Tile())->assignFromAssocArray($el), $rawData);
        $turn = new Turn();
        $turn->setGame($game);
        $turn->setField($output);

        $this->entityManager->persist($turn);
        $this->entityManager->flush();
        return $this->json($turn);
        // if there are no matches return we need to shuffle

        // return OK if nothing happened + match num
    }
}
