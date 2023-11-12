<?php

namespace App\Controller\Admin;

use App\Entity\LnList;
use Doctrine\ORM\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
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
            AssociationField::new('isOwned',label: 'Is Owned By'),

            AssociationField::new('lightNovels',label: 'Contains')
                ->setFormTypeOption('by_reference', false)
                //On autorise l'ajout dans une liste d'un lightnovel seulement si l'owner de la liste suit le lightnovel
                ->setFormTypeOption('query_builder', function (EntityRepository $lightNovelRepository) {
                    $currentList = $this->getContext()->getEntity()->getInstance();
                    $user = $currentList->getIsOwned();

                    return $lightNovelRepository->createQueryBuilder('ln')
                        ->join('ln.users', 'user')
                        ->where('user.id = :userId')
                        ->setParameter('userId', $user->getId());
                }),
        ];
    }

}
