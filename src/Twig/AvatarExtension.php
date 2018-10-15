<?php
/**
 * Created by PhpStorm.
 * User: Host
 * Date: 30.09.2018
 * Time: 20:38
 */

namespace App\Twig;

use App\Controller\UserController;
use Twig\Extension\AbstractExtension;
use Twig_Function;

class AvatarExtension extends AbstractExtension
{

    public function getFunctions()
    {
        return array(
            new Twig_Function('isAvatarExists', array($this, 'isAvatarExists')),
            new Twig_Function('getAvatar', array($this, 'getAvatar'))
        );
    }

    public function isAvatarExists(string $userID): bool
    {
        return UserController::isAvatarExists($userID);
    }

    public function getAvatar(string $userID): string
    {
        return UserController::getAvatarFile($userID);
    }
}
