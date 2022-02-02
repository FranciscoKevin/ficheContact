<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => "Prénom",
                "attr" => [
                    "placeholder" => "Votre prénom",
                    "class" => 'form-check'
                ],
            ])
            
            ->add('name', TextType::class, [
                "label" => "Nom",
                "attr" => [
                    "placeholder" => "Votre Nom",
                    "class" => 'form-check'
                ],
            ])

            ->add('email', EmailType::class, [
                "label" => "E-mail",
                "attr" => [
                    "placeholder" => "exemple@gmail.com",
                    "class" => 'form-check'
                ],
            ])

            ->add('department', null, [
                'choice_label' => 'departmentName',
                "label" => "Départements de l'entrprise",
                "attr" => [
                    "class" => 'form-check'
                ],
            ])

            ->add('message', TextareaType::class, [
                "label" => "Message",
                "attr" => [
                    "placeholder" => "Votre Message",
                    "class" => 'form-check'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
