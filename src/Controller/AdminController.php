<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Entity\User;
use App\Form\SettingType;
use App\Form\UserSettingType;
use App\Twig\Functions\FriendsFunctions;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, ManagerRegistry $doctrine, FriendsFunctions $friends): Response
    {
        $fl = $friends->getFriendsList();
        $settings = [];
        $repo = $doctrine->getRepository(Setting::class);
        foreach ($repo->findAll() as $s) {
            $settings[$s->getName()] = $s->getValue();
        }

        $form = $this->createForm(SettingType::class, $settings);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $settings = $form->getData();
            $entityManager = $doctrine->getManager();
            foreach ($settings as $k => $v) {
                $set = $repo->findOneByName($k);
                if (null === $set) {
                    $set = new Setting();
                }
                $set->setName($k)
                  ->setValue($v)
                ;
                $entityManager->persist($set);
                $entityManager->flush();
            }
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'friendslist' => $fl,
        ]);
    }

    #[Route('/admin/users', name: 'app_admin_user')]
    public function user(Request $request, ManagerRegistry $doctrine, FriendsFunctions $friends): Response
    {
        $fl = $friends->getFriendsList();
        $users = [];
        $repo = $doctrine->getRepository(User::class);
        foreach ($repo->findAll() as $s) {
            $users[$s->getId()] = [
                'username' => $s->getUsername(),
                'admin' => $s->hasRole('ROLE_ADMIN'),
                'locked' => $s->isLocked(),
            ];
        }

        return $this->render('admin/users.html.twig', [
            'friendslist' => $fl,
            'users' => $users,
        ]);
    }

    #[Route('/admin/users/{username}', name: 'app_admin_user_feed')]
    #[Entity('User', options: ['username' => 'username'])]
    public function userFeed(User $user, Request $request, ManagerRegistry $doctrine, FriendsFunctions $friends): Response
    {
        $fl = $friends->getFriendsList();
        $users = [];
        $repo = $doctrine->getRepository(User::class);
        $userData = [
                'username' => $user->getUsername(),
                'admin' => $user->hasRole('ROLE_ADMIN'),
                'locked' => $user->isLocked(),
            ];

        $form = $this->createForm(UserSettingType::class, $userData);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $settings = $form->getData();
            if (!$settings['admin']) {
                $user->removeRole('ROLE_ADMIN');
            } else {
                $user->addRole('ROLE_ADMIN');
            }
            $user->setUsername($settings['username'])
                ->setLocked($settings['locked'])
            ;
            $repo->save($user, true);
        }

        return $this->render('admin/index.html.twig', [
            'form' => $form->createView(),
            'friendslist' => $fl,
            'users' => $users,
        ]);
    }
}
