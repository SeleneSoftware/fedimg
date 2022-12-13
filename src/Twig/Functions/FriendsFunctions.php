<?php

namespace App\Twig\Functions;

use App\Entity\HostOrg;
use App\Entity\Post;
use App\Entity\Setting;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Security;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Twig\Extension\RuntimeExtensionInterface;

class FriendsFunctions implements RuntimeExtensionInterface
{
    protected $doctrine;

    protected $security;

    protected $settings;

    protected $client;

    public function __construct(ManagerRegistry $doctrine, Security $security, HttpClientInterface $client)
    {
        $this->doctrine = $doctrine;
        $this->security = $security;
        $this->settings = $doctrine->getRepository(Setting::class);
        $this->client = $client;
    }

    public function getFriendsList()
    {
        $user = $this->security->getUser();

        return $user->getProfile()->getFriends();
    }

    public function getUserPhotos(string $friendCode)
    {
        $code = explode('@', $friendCode);
        $siteCode = $this->settings->findOneByName('sitenick')->getValue();

        if ($code[1] === $siteCode) {
            $repo = $this->doctrine->getRepository(User::class);
            $friend = $repo->findOneByUsername($code[0]);

            $pubPosts = [];
            foreach ($friend->getPosts() as $post) {
                if ($post->isPublic()) {
                    $pubPosts[] = $post->setUsercode($friendCode);
                }
            }

            return $pubPosts;
        }

        $repo = $this->doctrine->getRepository(HostOrg::class);
        $host = $repo->findOneBySiteNick($code[1]);

        $response = $this->client->request(
            'GET',
            'https://'.$host->getUrl().'/api'
        );
        if (200 === $response->getStatusCode()) {
            $content = $response->toArray();
            if (!in_array($code[0], $content['Users'])) {
                return ['error' => 'No User Found'];
            }
        }
        $imagePath = $content['ImgPath'];

        $response = $this->client->request(
            'GET',
            'https://'.$host->getUrl().'/api/user/'.$code[0]
        );

        try {
            $content = $response->toArray();
        } catch (\Exception $e) {
            return ['error' => $response->toArray(false)];
        }
        $posts = [];
        foreach ($content['posts'] as $post) {
            $p = new Post();
            $p->setTitle($post['title'])
              ->setImageUrl($host->getUrl().$imagePath.$post['name'])
              ->setUpdatedAt(new \DateTimeImmutable($post['updated']['date'], new \DateTimeZone($post['updated']['timezone'])))
              ->setPublic(true)
              ->setUsercode($friendCode)
            ;
            $posts[] = $p;
        }

        return $posts;
    }

    public function getRandomHostsUsers()
    {
        $repo = $this->doctrine->getRepository(HostOrg::class);
        $hosts = $repo->findAll();
        shuffle($hosts);
        $ret = [];

        foreach (array_slice($hosts, 0, 10) as $h) {
            $response = $this->client->request(
                'GET',
                'https://'.$h->getUrl().'/api'
            );

            try {
                $content = $response->toArray();
            } catch (\Exception $e) {
                return ['error' => $response->toArray(false)];
            }

            $friends = $content['Users'];
            shuffle($friends);

            foreach (array_slice($friends, 0, 10) as $f) {
                $ret[] = $f.'@'.$content['SiteNick'];
            }
        }

        return $ret;
    }

    public function getFriendCode($post): string
    {
        if ($post->getUsercode()) {
            return $post->getUsercode();
        }
        $owner = $post->getOwner()->getUsername();
        $siteCode = $this->settings->findOneByName('siteNick')->getValue();

        $post->setUsercode($owner.'@'.$siteCode);

        return $post->getUsercode();
    }
}
