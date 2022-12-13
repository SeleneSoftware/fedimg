<?php

namespace App\Controller;

use App\Entity\HostOrg;
use App\Entity\Setting;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'api')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Setting::class);
        $u = $doctrine->getRepository(User::class)->findAll();
        $h = $doctrine->getRepository(HostOrg::class)->findAll();
        $users = [];
        $hosts = [];
        foreach ($u as $v) {
            $users[] = $v->getUsername();
        }
        foreach ($h as $v) {
            $hosts[$v->getNick()]['name'] = $v->getName();
            $hosts[$v->getNick()]['url'] = $v->getUrl();
        }
        // Any of the site settings are hard coded here because why not?
        $siteName = $repo->findOneByName('sitename');
        $siteNick = $repo->findOneByName('sitenick');
        $siteDesc = $repo->findOneByName('sitedesc');
        $response = new JsonResponse([
            'SiteName' => $siteName->getValue(),
            'SiteNick' => $siteNick->getValue(),
            'SiteDesc' => $siteDesc->getValue(),
            'Users' => $users,
            'HostOrg' => $hosts,
            'ImgPath' => '/images/products/', // This is hard-coded for now, but soon will be pulled from configs
        ]);

        return $response;
    }

    #[Route('/api/user/{username}', name: 'api-user')]
    #[Entity('User', options: ['username' => 'username'])]
    public function user(User $user, ManagerRegistry $doctrine)
    {
        $repo = $doctrine->getRepository(Setting::class);
        $posts = [];
        foreach ($user->getPosts() as $post) {
            if ($post->isPublic()) {
                $posts[$post->getId()] = [
                    'title' => $post->getTitle(),
                    'name' => $post->getImageName(),
                    'updated' => $post->getUpdatedAt(),
                    'nsfw' => $post->isNsfw(),
                ];
            }
        }
        $response = new JsonResponse([
            'username' => $user->getUsername(),
            'sitecode' => $repo->findOneByName('sitenick'),
            'posts' => $posts,
        ]);

        return $response;
    }

    #[Route('/api/announce', name: 'api-announce')]
    public function announce(ManagerRegistry $doctrine): Response
    {
        $response = new JsonResponse([]);

        return $response;
    }

    #[Route('/api/hosts', name: 'api-hosts')]
    public function listHosts(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(HostOrg::class);
        $hosts = $repo->findAll();
        foreach ($hosts as $h) {
            $response[] = [
                'name' => $h->getName(),
                'nick' => $h->getNick(),
                'url' => $h->getUrl(),
            ];
        }

        return new JsonResponse($response);
    }
}
