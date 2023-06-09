<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use App\Repository\WishRepository;
use http\Client\Curl\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class WishType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('title', TextType::class)
            ->add('description', TextareaType::class, [
                'required' => false,
                'label' => 'Describe your wish : ',
            ])
            ->add('author', TextType::class,)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'query_builder' => function (CategoryRepository $categoryRepository) {
                    $qb = $categoryRepository->createQueryBuilder('c');
                    $qb->addOrderBy('c.name', 'ASC');
                    return $qb;
                }


            ]);
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
