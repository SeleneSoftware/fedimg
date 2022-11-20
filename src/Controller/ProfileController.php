<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'profile')]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig', [
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
}
