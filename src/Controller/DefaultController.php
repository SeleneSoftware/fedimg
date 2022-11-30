<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'default')]
    public function index(UserRepository $users): Response
    {
        $u = $users->findAll();
        $posts = [];
        foreach ($u as $i) {
            $posts = array_merge($posts, $i->getPosts()->getValues());
        }

        return $this->render('default/index.html.twig', [
            'theme' => 'kunst',
            'feed' => $posts,
            // 'userCode' => $username.'@'.$sitecode,
        ]);
    }
}
