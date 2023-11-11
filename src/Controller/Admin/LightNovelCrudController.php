<?php

namespace  App\Controller\Admin;

use App\Entity\LightNovel;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            TextEditorField::new('description'),
            AssociationField::new('inGenre')
        ];
    }

}
