<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    #[Route('/feed/{username}', name: 'app_feed')]
    #[Entity('User', options: ['username' => 'username'])]
    public function index(User $user): Response
    {
        return $this->render('feed/index.html.twig', [
            'controller_name' => 'FeedController',
        ]);
    }
}
