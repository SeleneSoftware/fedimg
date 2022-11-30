<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Twig\Functions\FriendsFunctions;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(FriendsFunctions $friends): Response
    {
        $fl = $friends->getFriendsList();

        $posts = [];
        foreach ($fl as $friend) {
            $posts = array_merge($posts, $friends->getUserPhotos($friend));
        }

        usort($posts, function ($a, $b) {
            if ($a->getUpdatedAt() == $b->getUpdatedAt()) {
                return 0;
            }

            return $a->getUpdatedAt() < $b->getUpdatedAt() ? -1 : 1;
        });

        return $this->render('profile/index.html.twig', [
            'up' => $posts,
            'friendslist' => $fl,
        ]);
    }

    #[Route('/profile/upload', name: 'upload')]
    public function uploadImg(Request $request, ManagerRegistry $doctrine, FriendsFunctions $friends): Response
    {
        $fl = $friends->getFriendsList();

        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setOwner($this->getUser());

            $manager = $doctrine->getManager();
            $manager->persist($post);
            $manager->flush();

            return $this->redirectToRoute('profile');
        }

        return $this->render('profile/upload.html.twig', [
            'form' => $form->createView(),
            'friendslist' => $fl,
        ]);
    }

    #[Route('/profile/settings', name: 'profile_settings')]
    public function settings(ManagerRegistry $doctrine, FriendsFunctions $friends): Response
    {
        $fl = $friends->getFriendsList();

        return $this->render('profile/index.html.twig', [
        ]);
    }

    #[Route('/profile/feed', name: 'profile_feed')]
    public function feed(FriendsFunctions $friends): Response
    {
        $fl = $friends->getFriendsList();

        return $this->render('profile/index.html.twig', [
            'up' => $this->getUser()->getPosts(),
            'friendslist' => $fl,
        ]);
    }

    #[Route('/profile/{friendcode}', name: 'profile_friend')]
    public function friendFeed(FriendsFunctions $friends, string $friendcode): Response
    {
        $fl = $friends->getFriendsList();

        return $this->render('profile/index.html.twig', [
            'up' => $friends->getUserPhotos($friendcode),
            'friendslist' => $fl,
        ]);
    }
}
