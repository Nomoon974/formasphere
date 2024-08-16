<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img style="border-radius: 5px; border: solid 1px rgb(24,48,69); width: 95%" src="build/images/formasphere.cfc68f6b.png"> Formasphere')
            ->setFaviconPath('build/images/formasphere.cfc68f6b.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Acceuil', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', UserCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Documents", 'fa-solid fa-file', DocumentsCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Contents", 'fa-solid fa-folder', ContentsCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Module", 'fa-solid fa-book', ModuleCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Report", 'fa-solid fa-flag', ReportCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Chat", 'fa-solid fa-comment', ChatsCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Archive", 'fa-solid fa-box-archive', ArchivingCrudController::getEntityFqcn());
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        // Usually it's better to call the parent method because that gives you a
        // user menu with some menu items already created ("sign out", "exit impersonation", etc.)
        // if you prefer to create the user menu from scratch, use: return UserMenu::new()->...
        return parent::configureUserMenu($user)
            // use the given $user object to get the user name
            // use this method if you don't want to display the name of the user
            ->displayUserName(true)

            // you can return an URL with the avatar image
            ->setAvatarUrl($user->getAvatar())
            // use this method if you don't want to display the user image
            ->displayUserAvatar(false);
            // you can also pass an email address to use gravatar's service
            // you can use any type of menu item, except submenus
    }
}
