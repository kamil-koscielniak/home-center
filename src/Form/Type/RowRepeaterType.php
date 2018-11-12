<?php
namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class RowRepeaterType extends AbstractType
{
    public function getParent()
    {
        return TextType::class;
    }
}
