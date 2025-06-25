<?php

namespace App\Controller\Admin;

use App\Entity\Glace;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GlaceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Glace::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        
        return [
            TextField::new('nom'),
            TextField::new('secretIngredient'),

            //Configuration pour l'image en 2 partie, une pour l'affichage et une pour le formulaire
            TextField::new('imageFile', 'Image')
            ->setFormType(VichImageType::class)
            ->onlyOnForms(), //On spécifie que ce champs sera uniquement pour le formulaire
            ImageField::new('imageName', 'Image')
                ->setBasePath('images/upload') // Chemin public vers les images
                ->onlyOnIndex(),//On spécifie que ce champs sera uniquement pour l'affichage de l'image'

            //Relation ManyToOne
            AssociationField::new('cornet', 'le cornet')
            ->setFormTypeOptions([
                'choice_label'=>'label',
            ]),

            //Relation ManyToMany
           AssociationField::new('topping', 'les topping')
            ->setFormTypeOptions([
                'by_reference'=>false,
                'multiple'=>true,
                'choice_label'=>'label'
                //Affichage du many to many
            ]) ->formatValue(function ($value, $entity) {
                
                    $labels = [];
                    foreach ($value as $topping) {
                        $labels[] = $topping->getLabel();
                    }
                    return implode(', ', $labels);
           
                return '';
            }),
            
        ];
    }
    
}
