<?php

namespace App\Form;

use App\Entity\Inscription;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'oninput' => 'this.value=this.value.replace(/[^a-zA-Z\s-]/g,"");', // Empêche l'entrée de ponctuation et de chiffres sauf le tiret
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le nom est obligatoire.']),
                    new Length(['max' => 255, 'maxMessage' => 'Le nom ne peut pas dépasser {{ limit }} caractères.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s-]+$/',
                        'message' => 'Le nom ne peut contenir que des lettres, des espaces et des tirets.'
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'oninput' => 'this.value=this.value.replace(/[^a-zA-Z\s-]/g,"");', // Empêche l'entrée de ponctuation sauf le tiret
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Le prénom est obligatoire.']),
                    new Length(['max' => 255, 'maxMessage' => 'Le prénom ne peut pas dépasser {{ limit }} caractères.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z\s-]+$/',
                        'message' => 'Le prénom ne peut contenir que des lettres, des espaces et des tirets.'
                    ]),
                ],
            ])
            ->add('adresse', TextType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'placeholder' => 'n° rue - rue - code postal - ville',
                    'oninput' => 'this.value=this.value.replace(/[^a-zA-Z0-9\s-]/g,"");', // Empêche l'entrée de ponctuation sauf le tiret
                ],
                'constraints' => [
                    new NotBlank(['message' => 'L\'adresse est obligatoire.']),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\s-]+$/',
                        'message' => 'L\'adresse ne peut contenir que des lettres, des chiffres, des espaces et des tirets.'
                    ]),
                ],
            ])
            ->add('telephone', TelType::class, [
                'attr' => [
                    'class' => 'form-control mb-2',
                    'label' => 'N° mobile ou fixe',
                    'placeholder' => '06XXXXXXXX',
                    'maxlength' => 10, // Limite à 10 caractères
                    'oninput' => 'this.value=this.value.replace(/[^0-9]/g,"");', // Interdire l'entrée de lettres
                ],
                'constraints' => [
                    new Length(['min' => 10, 'max' => 10, 'exactMessage' => 'Le numéro de téléphone doit contenir exactement 10 chiffres.']), // Exige 10 caractères
                    new Regex([
                        'pattern' => '/^0[1-9]\d{8}$/', // Doit commencer par 0 et contenir 10 chiffres au total
                        'message' => 'Le numéro de téléphone doit contenir 10 chiffres et commencer par 0.',
                    ]),
                ],
            ])
            ->add('email', EmailType::class, [
                'attr' => ['class' => 'form-control mb-2'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez entrer une adresse email.']),
                    new Email(['message' => 'L\'adresse email "{{ value }}" n\'est pas valide.']),
                ],
            ])
            ->add('disciplines', ChoiceType::class, [
                'choices' => [
                    'jiu-jitsu brésilien' => 'jiu-jitsu brésilien',
                    'vale tudo' => 'vale tudo',
                    'self-défense' => 'self-défense',
                    'atemi ju-jutsu' => 'atemi ju-jutsu',
                    'mushin-ryu' => 'mushin-ryu',
                    'zen hakko kaï' => 'zen hakko kaï',
                ],
                'attr' => ['class' => 'form-control custom-select mb-2'],
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner une discipline.']),
                ],
            ])
            ->add('rib', FileType::class, [
                'attr' => ['class' => 'form-control mb-2'],
                'data_class' => null,
                'label' => 'Image',
                'required' => true,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez sélectionner au moins une image.']),
                    new File([
                        'maxSize' => '15M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/gif',
                            'application/pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image au format JPEG, PNG, GIF ou PDF.',
                    ]),
                ],
            ])
            ->add('commentaires', TextareaType::class, [
                'attr' => ['class' => 'form-control', 'style' => 'height:200px'],
                'required' => false,
            ])
            ->add('envoyer', SubmitType::class, [
                'label' => isset($options['label']) ? $options['label'] : 'envoyer',
                'attr' => ['class' => 'btn btn-outline-info mt-2 px-3'],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Inscription::class,
        ]);
    }
}
