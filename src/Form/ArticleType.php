<?php

namespace App\Form;

use App\Entity\Article;
<<<<<<< HEAD
use App\Entity\Categorie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
=======
use Doctrine\DBAL\Types\TextType as TypesTextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;
>>>>>>> 9953f0185306168e882550e7ab66a9b8309f44e8

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
<<<<<<< HEAD
            ->add('titre', TextType::class, [
=======
            ->add('titre', TextType::class,[
>>>>>>> 9953f0185306168e882550e7ab66a9b8309f44e8
                'label' => 'Titre:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Titre de votre article',
                ]
            ])
<<<<<<< HEAD
            ->add('categories', EntityType::class,[
                'class' => Categorie::class,
                'choice_label' => 'titre',
                'expanded' => false,
                'multiple' => true,
                'by_reference' => false,
                'autocomplete' => true,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->andWhere('c.actif = true')
                        ->orderBy('c.titre', 'ASC');
            },
            ])
            
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image:',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image',
                'download_uri' => false,
                'image_uri' => true,
            ])
=======
            ->add('imageFile', VichImageType::class,[ //ajout et traitement d'image dans l'article avec Vichimage
                'label' => 'Image:',
                'required' => false,
                'allow_delete'=>true,
                'delete_label'=> 'Supprimer l\'image',
                'download_uri'=> false,
                'image_uri'=> true, 
                ])
>>>>>>> 9953f0185306168e882550e7ab66a9b8309f44e8
            ->add('contenu', TextareaType::class, [
                'label' => 'Contenu:',
                'required' => true,
                'attr' => [
                    'placeholder' => 'Contenu de votre article',
                    'rows' => 5,
                ]
            ])
            ->add('actif', CheckboxType::class, [
                'label' => 'Actif',
                'required' => false,
            ]);
<<<<<<< HEAD
=======
        
>>>>>>> 9953f0185306168e882550e7ab66a9b8309f44e8
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
