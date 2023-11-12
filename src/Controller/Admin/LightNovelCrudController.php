<?php

namespace  App\Controller\Admin;

use App\Entity\LightNovel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use App\Field\VichImageField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class LightNovelCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LightNovel::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('Title'),
            TextField::new('Author'),
            VichImageField::new('image')
                ->hideOnForm()
                ->HideOnIndex(),
            VichImageField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->HideOnIndex(),
            TextEditorField::new('description'),
            AssociationField::new('inGenre')
        ];
    }

}
