<?php
/**
 * Created by PhpStorm.
 * User: Host
 * Date: 30.09.2018
 * Time: 20:38
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig_Function;

class AvatarExtension extends AbstractExtension
{
    const AVATAR_PATH = 'images/avatars/';
    const AVATAR_NAME_PREFIX = 'avt';

    public function getFunctions()
    {
        return array(
            new Twig_Function('isAvatarExists', array($this, 'isAvatarExists')),
            new Twig_Function('getAvatar', array($this, 'getAvatar'))
        );
    }

    public function isAvatarExists(string $userID): bool
    {
        return file_exists($this->getAvatarName($userID));
    }

    public function getAvatar(string $userID): string
    {
        return $this->getAvatarName($userID);
    }

    private function getAvatarName(string $userID): string
    {
        return self::AVATAR_PATH . self::AVATAR_NAME_PREFIX . $userID.'.jpg';
    }
}
