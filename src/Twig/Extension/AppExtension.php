<?php

namespace App\Twig\Extension;

use App\Twig\Functions\FriendsFunctions;
use App\Twig\Runtime\AppExtensionRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    protected $friends;

    public function __construct(FriendsFunctions $friends)
    {
        $this->friends = $friends;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [AppExtensionRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('friendslist', [FriendsFunctions::class, 'getFriendsList']),
            new TwigFunction('userphotos', [FriendsFunctions::class, 'getUserPhotos']),
            new TwigFunction('friendcode', [$this->friends, 'getFriendCode']),
        ];
    }
}
