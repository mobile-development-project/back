<?php

namespace App\Controller\Admin;

use App\Entity\Assignment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class AssignmentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn (): string
    {
        return Assignment::class;
    }

    public function configureFields (string $pageName): iterable
    {
        return [
            TextField::new("name", "Nom"),
            AssociationField::new("course", "Cours"),
            DateTimeField::new("createdAt", "Créé à"),
            DateTimeField::new("finishAt", "Fini à"),
        ];
    }
}
