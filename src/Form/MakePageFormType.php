<?php

namespace App\Form;

use App\Entity\Documentation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MakePageFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $documentation = new Documentation();

        $builder
            ->add('More', ChoiceType::class, [
                'choices'  => [
                    'Text' => $documentation,
                    'Document' => $documentation,
                ], 'allow_extra_fields' => true,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event){
                $class= $event->getData();
                $class['new_field'] = FileType::class;
                $event->setData($class);
            })
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
