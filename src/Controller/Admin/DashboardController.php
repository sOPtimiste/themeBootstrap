<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Announce;
use App\Controller\AdminDashboardController;
use App\Repository\AnnounceRepository;
use App\Repository\UserRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    protected $userRepository;
    protected $announceRepository;
    public function __construct(UserRepository $userRepository,AnnounceRepository $announceRepository)
    {
        $this->userRepository = $userRepository;
        $this->announceRepository = $announceRepository;
    }
    /**
     * @Route("/admin", name="app_admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig',[

            'countAllUsers' => $this->userRepository->getCountUser(),
            'countAllAnnounces' => $this->announceRepository->getCountAnnounce()
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Gestion des Annonces');

    }
    public function configureAssets(): Assets
    {
        return Assets::new()
            ->addCssFile('css/bgAdmin/style.css')
         ;   
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linktoRoute('Page Accueil', 'fas fa-home', 'app_home'),
            
            MenuItem::section('Annonces'),
            MenuItem::linkToCrud('Annonces', 'fas fa-newspaper', Announce::class),


            MenuItem::section('Utilisateurs'),
            MenuItem::linkToCrud('Utilisateur', 'fas fa-user', User::class),

            

        ];
        //yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');

        //yield MenuItem::linkToCrud('Annonces', 'fas fa-newspaper', Announce::class);
        //yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
        //yield MenuItem::linktoRoute('Page Accueil', 'fas fa-home', 'app_home');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            ->setName($user->getUserIdentifier())
            ->setMenuItems([
                MenuItem::linkToLogout('Deconnexion','fa fas-sign-out','app-logout')
            ])
            ->setGravatarEmail($user->getUserIdentifier())
            ->displayUserAvatar(true)


            ->addMenuItems([
                MenuItem::linkToRoute('My profile','fa fas-id-card',''),
                MenuItem::linkToRoute('Setting','fa fa-user-cog','')
           ])

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
