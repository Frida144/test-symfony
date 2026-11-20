<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // empty_data '' : un champ vide donne '' (et non null), c'est #[Assert\NotBlank] qui affiche l'erreur
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'empty_data' => '',
            ])
            ->add('author', TextType::class, [
                'label' => 'Auteur',
                'empty_data' => '',
            ])
            ->add('resume', TextareaType::class, [
                'label' => 'Résumé',
                'empty_data' => '',
            ])
            ->add('publishAt', DateType::class, [
                'label' => 'Date de publication',
                'widget' => 'single_text',            // un seul champ <input type="date">
                'input' => 'datetime_immutable',      // l'entité attend un DateTimeImmutable
            ])
            ->add('categories', EntityType::class, [
                'label' => 'Catégories',
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,                   // relation ManyToMany : plusieurs choix
                'expanded' => true,                   // affichées en cases à cocher
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
