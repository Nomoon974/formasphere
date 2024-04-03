<?php

namespace App\Controller\Admin;

use App\Entity\Roles;
use Doctrine\DBAL\Types\ArrayType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\FormTypeInterface;

class RolesCrudController extends AbstractCrudController
{

    public static function getEntityFqcn(): string
    {
        return Roles::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('role_name', "Role Utilisateur")->setChoices([
                "admin" => "ROLE_ADMIN",
                "user"  => "ROLE_USER",
                "student"   => "ROLE_STUDENT"
            ])->allowMultipleChoices(true)->addCssClass('custom-pointer')
        ];
    }
}
