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
        return $this->render('pages/mainPage.html.twig');
    }

    #[Route(
        '/mahjong',
        name: 'app_mahjong',
        methods: ['GET']
    )]
    public function mahgongIndex(): Response
    {
        return $this->render('pages/mahjong.html.twig');
    }
    #[Route(
        '/admin',
        name: 'app_admin',
        methods: ['GET']
    )]
    public function adminIndex(): Response
    {
        return $this->render('pages/admin.html.twig');
    }
}
