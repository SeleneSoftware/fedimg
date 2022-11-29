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
        return $this->render('profile/index.html.twig', [
            'up' => $friends->getUserPhotos('bunny@fedimgdev'),
        ]);
    }

    #[Route('/profile/upload', name: 'upload')]
    public function uploadImg(Request $request, ManagerRegistry $doctrine): Response
    {
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
        ]);
    }

    #[Route('/profile/settings', name: 'profile_settings')]
    public function settings(): Response
    {
        return $this->render('profile/index.html.twig', [
        ]);
    }

    #[Route('/profile/feed', name: 'profile_feed')]
    public function feed(): Response
    {
        return $this->render('profile/index.html.twig', [
        ]);
    }
}
