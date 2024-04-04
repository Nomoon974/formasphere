<?php

namespace App\Controller\Admin;

use App\Entity\Documents;
use App\Entity\Program;
use App\Entity\Trainee;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\UserController;

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
            ->setTitle('<img style="border-radius: 10px; border: solid 3px rgb(24,48,69); width: 95%" src="build/images/formasphere.cfc68f6b.png"> Formasphere')
            ->setFaviconPath('build/images/formasphere.cfc68f6b.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Acceuil', 'fa fa-home');
        yield MenuItem::linkToCrud('Utilisateur', 'fas fa-user', UserCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud('Role Utilisateur', 'fa-solid fa-id-badge', RolesCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Documents", 'fa-solid fa-file', DocumentsCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Contents", 'fa-solid fa-folder', ContentsCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Module", 'fa-solid fa-book', ModuleCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Program", 'fa-solid fa-gears', ProgramCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Report", 'fa-solid fa-flag', ReportCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Chat", 'fa-solid fa-comment', ChatsCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Trainee", 'fa-solid fa-people-group', TraineeCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Trainings", 'fa-solid fa-pen-nib', TrainingsCrudController::getEntityFqcn());
        yield MenuItem::linkToCrud("Archive", 'fa-solid fa-box-archive', ArchivingCrudController::getEntityFqcn());
    }
}
