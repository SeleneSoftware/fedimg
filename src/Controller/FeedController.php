<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    #[Route('/feed/{username}', name: 'feed')]
    #[Entity('User', options: ['username' => 'username'])]
    public function index(User $user): Response
    {
        // Once I get more in the profiles, I'll make more of the themes and this will make sense.
        return $this->render('feed/index.html.twig', [
            'theme' => 'kunst',
        ]);
    }
}
