<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('text', TextareaType::class, [
            'label' => 'Votre commentaire',
            'attr' => [
                'rows' => 5,
                'minlength' => 10,
                'maxlength' => 1500,
                'style' => 'height:none',
            ],
            'constraints' => [
                new Length([
                    'min' => 10,
                    'minMessage' => 'Votre commentaire doit contenir au moins {{ limit }} caractères.',
                    'max' => 1500,
                    'maxMessage' => 'Votre commentaire ne peut pas dépasser {{ limit }} caractères.',
                ]),
            ]
        ]);
    }
}
