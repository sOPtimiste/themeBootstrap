<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Announce;
use App\Controller\AdminDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion des Annonces');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Annonces', 'fas fa-newspaper', Announce::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        yield MenuItem::linktoRoute('Page Accueil', 'fas fa-home', 'app_home');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUserIdentifier())
            ->setGravatarEmail($user->getUserIdentifier())
            ->displayUserAvatar(true)

            //->addMenuItems([
                //MenuItem::linkToLogout('Deconnexion','fa fas-sign-out','app-logout')
           // ])

        ;
    }

    /*protected function createEditUrl($id): string
    {
        return $this->crudUrlGenerator->build()
            ->setDashboard(AdminDashboardController::class)
            ->setAction(Action::EDIT)
            ->setEntityId($id);
    }*/
}
