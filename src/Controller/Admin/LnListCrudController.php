<?php

namespace App\Controller\Admin;

use App\Entity\LnList;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LnListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LnList::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            AssociationField::new('isOwned'),
            /*
            AssociationField::new('lightnovels')
                ->onlyOnForms()
                // on ne souhaite pas gérer l'association entre les
                // lightnovels et la LnList dès la création de la
                // LnList
                ->hideWhenCreating()
                ->setTemplatePath('admin/fields/[inventaire]_lightnovels.html.twig')
                // Ajout possible seulement pour des lightnovels qui
                // appartiennent même propriétaire de l'[inventaire]
                // que le User de la LnList
                ->setQueryBuilder(
                    function (QueryBuilder $queryBuilder) {
                        // récupération de l'instance courante de LnList
                        $currentLnList = $this->getContext()->getEntity()->getInstance();
                        $User = $currentLnList->getUser();
                        $memberId = $User->getId();
                        // charge les seuls lightnovels dont le 'owner' de l'[inventaire] est le User de la galerie
                        $queryBuilder->leftJoin('entity.[inventaire]', 'i')
                            ->leftJoin('i.owner', 'm')
                            ->andWhere('m.id = :member_id')
                            ->setParameter('member_id', $memberId);
                        return $queryBuilder;
                    }
                ),
            */
        ];
    }

}
