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
        ]);

        return $response;
    }

    #[Route('/api/user/{user}', name: 'api-user')]
    #[Entity('User', options: ['username' => 'username'])]
    public function user(User $user, ManagerRegistery $doctrine)
    {
        $response = new JsonResponse([]);

        return $response;
    }

    #[Route('/api/announce', name: 'api-announce')]
    public function announce(ManagerRegistry $doctrine): Response
    {
        $response = new JsonResponse([]);

        return $response;
    }
}
