<?php
/**
 * Created by PhpStorm.
 * User: Host
 * Date: 30.09.2018
 * Time: 19:32
 */

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig_Function;

class AppExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return array(
          new Twig_Function('isFileExists', array($this, 'isFileExists'))
        );
    }

    public function isFileExists(string $file): bool
    {
        return file_exists($file);
    }
}
