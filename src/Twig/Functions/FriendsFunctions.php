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
                    $pubPosts[] = $post;
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
            $imagePath = $content['ImgPath'];
        }

        $response = $this->client->request(
            'GET',
            'https://'.$host->getUrl().'/api/user/'.$code[0]
        );

        if (200 !== $response->getStatusCode()) {
            return ['error' => 'No Message Yet'];
        }

        $content = $response->toArray();
        $posts = [];
        foreach ($content['posts'] as $post) {
            $p = new Post();
            $p->setTitle($post['title'])
              ->setImageUrl($host->getUrl().$imagePath.$post['name'])
              ->setUpdatedAt(new \DateTimeImmutable($post['updated']['date'], new \DateTimeZone($post['updated']['timezone'])))
            ;
            $posts[] = $p;
        }

        return $posts;
    }
}
