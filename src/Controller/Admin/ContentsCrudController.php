<?php

namespace App\Controller\Admin;

use App\Entity\Contents;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ContentsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Contents::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('content_type', "Contenu")
                ->setLabel('Type de contenu')
                ->setChoices([
                    'option 1' => 'temporaire'
                ]),
            TextField::new('content_link', "Lien contenu"),
            TextField::new('category', "Catégorie"),
            DateTimeField::new('publication_date', "Date de publication")
        ];
    }
}
