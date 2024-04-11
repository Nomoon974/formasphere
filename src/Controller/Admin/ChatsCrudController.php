<?php

namespace App\Controller\Admin;

use App\Entity\Chats;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ChatsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chats::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(), // Masquer l'ID lors de la création/édition
            AssociationField::new('user', 'Utilisateur')
                ->setCrudController(UserCrudController::class)
                ->formatValue(function ($value, $entity) {
                    return $entity->getUser()->getFullName(); // Assure-toi d'avoir une méthode getFullName() dans ton entité User
                }),
            AssociationField::new('space', 'Espace')
                ->setCrudController(SpacesCrudController::class)
                ->formatValue(function ($value, $entity) {
                    return $entity->getSpace()->getSpaceName(); // Assure-toi que ton entité Spaces a une méthode getName()
                }),
            AssociationField::new('chatMessages', 'Messages')
                ->setCrudController(ChatMessageCrudController::class)
                ->formatValue(function ($value, $entity) {
                    // Formate les messages pour affichage, ajuste selon tes besoins
                    return implode(', ', $entity->getChatMessages()->map(fn($msg) => $msg->getContent())->toArray());
                })
                ->hideOnIndex(), // Optionnellement, masquer sur la vue liste si trop volumineux
        ];
    }

}
