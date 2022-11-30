<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\SettingRepository;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedController extends AbstractController
{
    #[Route('/feed/{username}', name: 'feed')]
    #[Entity('User', options: ['username' => 'username'])]
    public function index(User $user, SettingRepository $setting): Response
    {
        $username = $user->getUsername();
        $sitecode = $setting->findOneByName('sitenick')->getValue();

        // Once I get more in the profiles, I'll make more of the themes and this will make sense.
        return $this->render('feed/index.html.twig', [
            'theme' => 'kunst',
            'feed' => $user->getPosts(),
            'userCode' => $username.'@'.$sitecode,
        ]);
    }

    #[Route('/feed/follow/{usercode}', name: 'feed-follow')]
    public function follow(ManagerRegistry $doctrine, string $usercode): Response
    {
        $profile = $this->getUser()->getProfile();
        $profile->addFriend($usercode);

        $em = $doctrine->getManager();
        $em->persist($profile);
        $em->flush();

        return $this->redirectToRoute('feed', ['username' => 'jason']);
    }
}
