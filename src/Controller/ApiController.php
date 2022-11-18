<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    #[Route('/api', name: 'app_api')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repo = $doctrine->getRepository(Setting::class);
        $u = $doctrine->getRepository(User::class)->findAll();
        $users = [];
        foreach ($u as $v) {
            $users[] = $v->getUsername();
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
        ]);

        return $response;
    }
}
