<?php

namespace App\Form;

use App\Entity\Country;
use App\Entity\Game;
use App\Entity\Genre;
use App\Entity\Publisher;
use Doctrine\ORM\EntityRepository;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GameType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('publishedAt', DateType::class, [
                'label' => 'Date de sortie',
                'widget' => 'single_text',
                'attr' => [
                    'max' => date('Y-m-d')
                ]
            ])
            ->add('price', NumberType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => 'Prix',
                    'min' => 0
                ],
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
            ])
            ->add('thumbnailCover', TextType::class, [
                'label' => 'Image de couverture',
                'attr' => [
                    'placeholder' => 'Image de couverture'
                ]
            ])
            ->add('thumbnailLogo', TextType::class, [
                'label' => 'Logo',
                'required' => false,
                'attr' => [
                    'placeholder' => 'Logo'
                ]
            ])
            ->add('publisher', EntityType::class, [
                'required' => false,
                'class' => Publisher::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.name', 'ASC')
                    ;
                }
            ])
            ->add('countries', CollectionType::class, [
                'label' => 'Pays',
                'attr' => [
                    'data-list-selector' => 'countries'
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Country::class,
                    'choice_label' => 'nationality',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('c')
                            ->orderBy('c.nationality', 'ASC')
                        ;
                    }
                ]
            ])
            ->add('addCountry', ButtonType::class, [
                'label' => 'Ajouter un pays',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'data-btn-selector' => 'countries',
                ]
            ])
            ->add('genres', CollectionType::class, [
                'label' => 'Genres',
                'attr' => [
                    'data-list-selector' => 'genres'
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'entry_type' => EntityType::class,
                'entry_options' => [
                    'label' => false,
                    'class' => Genre::class,
                    'choice_label' => 'name',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('g')
                            ->orderBy('g.name', 'ASC')
                        ;
                    }
                ]
            ])
            ->add('addGenre', ButtonType::class, [
                'label' => 'Ajouter un genre',
                'attr' => [
                    'class' => 'btn btn-primary',
                    'data-btn-selector' => 'genres',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Game::class,
        ]);
    }
}
