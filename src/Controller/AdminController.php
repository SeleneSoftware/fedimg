<?php

namespace App\Controller;

use App\Entity\Setting;
use App\Form\SettingType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
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
        ]);
    }
}
