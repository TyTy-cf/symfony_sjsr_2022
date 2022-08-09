<?php

namespace App\Form\Filter;

use App\Entity\Country;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\NumberFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class AccountFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('email', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ])
            ->add('nickname', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS,
            ])
            ->add('wallet', NumberFilterType::class, [
                'condition_operator' => FilterOperands::OPERATOR_EQUAL,
            ])
            ->add('country', EntityFilterType::class, [
                'class' => Country::class,
                'choice_label' => 'nationality',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.nationality', 'ASC')
                    ;
                }
            ])
            ->add('createdAt', DateRangeFilterType::class, [
                'left_date_options' => [
                    'label' => 'De',
                    'widget' => 'single_text',
                ],
                'right_date_options' => [
                    'label' => 'à',
                    'widget' => 'single_text',
                ]
            ])
        ;
    }

}