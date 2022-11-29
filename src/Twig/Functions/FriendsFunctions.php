<?php

namespace App\Twig\Functions;

use App\Entity\Setting;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Twig\Extension\RuntimeExtensionInterface;

class FriendsFunctions implements RuntimeExtensionInterface
{
    protected $doctrine;

    protected $security;

    protected $settings;

    public function __construct(ManagerRegistry $doctrine, Security $security)
    {
        $this->doctrine = $doctrine;
        $this->security = $security;
        $this->settings = $doctrine->getRepository(Setting::class);
    }

    public function getFriendsList(string $username = null)
    {
        $user = $this->security->getUser();

        return json_decode($user->getFriends());
    }

    public function getUserPhotos(string $friendCode)
    {
        $code = explode('@', $friendCode);
        $siteCode = $this->settings->findOneByName('sitenick')->getValue();

        if ($code[1] === $siteCode) {
            $repo = $this->doctrine->getRepository(User::class);
            $friend = $repo->findOneByUsername($code[0]);

            foreach ($friend->getPosts() as $post) {
                if ($post->isPublic()) {
                    $pubPosts[] = $post;
                }
            }

            return $pubPosts;
        }

        return [];
    }
}
