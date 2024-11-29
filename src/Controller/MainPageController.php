<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainPageController extends AbstractController
{
    #[Route(
        '/',
        name: 'app_mainPage',
        methods: ['GET']
    )]
    public function index(): Response
    {
        return $this->render('pages/mahjong.html.twig');
    }
}
