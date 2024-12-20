<?php

namespace App\Form;

use App\Entity\Posts;
use App\Entity\Spaces;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class PostsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('text', TextareaType::class, [
                'attr' => [
                    'readonly' => true,
                    'aria-hidden' => 'true',
                    'style' => 'display:none;',
                ],
                'label_attr' => [
                    'class' => 'hidden-label',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le contenu ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 5,
                    ]),
                    new Callback(function ($object, ExecutionContextInterface $context) {
                        if (trim(strip_tags($object)) === '') {
                            $context->buildViolation('Le contenu ne peut pas être vide.')
                                ->addViolation();
                        }
                    })
                ],
            ])
            ->add('editContent', TextareaType::class, [
                'mapped' => false,
                'attr' => [
                    'readonly' => true,
                    'aria-hidden' => 'true',
                    'style' => 'display:none;',
                    'class' => 'quill-editor',
                ],
                'label_attr' => [
                    'class' => 'hidden-label',
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le contenu ne peut pas être vide.',
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 10000,
                        'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'Le contenu ne peut pas dépasser {{ limit }} caractères.',

                    ]),
                    new Callback(function ($object, ExecutionContextInterface $context) {
                        if (trim(strip_tags($object)) === '') {
                            $context->buildViolation('Le contenu ne peut pas être vide.')
                                ->addViolation();
                        }
                    })
                ],
            ])
            ->add('created_at', HiddenType::class, [
                'mapped' => false,
                'data' => $options['data']->getCreatedAt()->format('d-m-Y H:i:s'),
            ])
            ->add('updated_at', HiddenType::class, [
                'mapped' => false,
                'data' => $options['data']->getUpdatedAt() ? $options['data']->getUpdatedAt()->format('d-m-Y H:i:s') : '',
            ])
            ->add('user', HiddenType::class, [
                'mapped' => false,
                'data' => $options['data']->getUser()->getId(),
            ])
            ->add('space', HiddenType::class, [
                'mapped' => false,
                'data' => $options['data']->getSpace()->getId(),
            ])
            ->add('document', FileType::class, [
                'mapped' => false, // pour que ce champ ne soit pas automatiquement lié à l’entité Posts
                'multiple' => true, // autorise l'upload multiple
                'required' => false,
                'attr' => [
                    'accept' => '.pdf, .docx, .pptx, .xlsx, .zip, .txt, .py, .java, .cpp, .jpg, .jpeg, .png, .gif, .svg',
                    'style' => 'display:none',
                    'id' => 'document-input'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Posts::class,
            'allow_file_upload' => true,
        ]);
    }
}
