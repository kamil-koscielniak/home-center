<?php
/**
 * Created by PhpStorm.
 * User: Host
 * Date: 05.10.2018
 * Time: 20:59
 */

namespace App\Form;

use App\Form\Type\AvatarType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class Avatar extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('avatar', AvatarType::class)
        ;
    }
}
