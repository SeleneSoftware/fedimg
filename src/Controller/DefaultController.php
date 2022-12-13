<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Twig\Functions\FriendsFunctions;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default', options: ['sitemap' => true])]
    public function index(UserRepository $users, FriendsFunctions $friends): Response
    {
        $u = $users->findAll();
        $posts = [];
        foreach ($u as $i) {
            $posts = array_merge($posts, $i->getPosts()->getValues());
        }

        if ($this->getUser()) {
            $f = $friends->getRandomHostsUsers();
            foreach ($f as $u) {
                $posts = array_merge($posts, $friends->getUserPhotos($u));
            }
            // dump($posts);
        }

        return $this->render('default/index.html.twig', [
            'theme' => 'kunst',
            'feed' => $posts,
            // 'userCode' => $username.'@'.$sitecode,
        ]);
    }
}
