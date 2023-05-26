<?php

namespace App\Form;

use App\Entity\Article;
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

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [                   //Toujours bien penser a importer les classes qu'on a crée
                'label' => 'Titre:',                            // je dis a mon builder de crée une table Titre de type texte area
                'required' => true,                             // c'est obligatoire
                'attr' => [
                    'placeholder' => 'Titre de votre article',  // une fois que c'est finis la page affiche titre de votre article :  
                ]
            ])
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
                'required' => false,
            ])
            
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image:',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image',
                'download_uri' => false,
                'image_uri' => true,
            ])
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
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
