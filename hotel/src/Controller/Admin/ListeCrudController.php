<?php

namespace App\Controller\Admin;

use App\Entity\Liste;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ListeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Liste::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
