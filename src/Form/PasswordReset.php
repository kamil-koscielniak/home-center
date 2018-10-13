<?php
/**
 * Created by PhpStorm.
 * User: Host
 * Date: 05.10.2018
 * Time: 20:59
 */

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;

class PasswordReset extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class)
            ->add('newPassword', PasswordType::class)
            ->add('repeatedNewPassword', PasswordType::class)
        ;
    }
}
