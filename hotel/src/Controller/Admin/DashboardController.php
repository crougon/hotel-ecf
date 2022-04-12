<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Liste;
use App\Entity\Reservation;
use App\Entity\Room;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(RoomCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Admin');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Hotel');
        yield MenuItem::linkToCrud('Suites', 'fa fa-solid fa-bed', Room::class);
        yield MenuItem::linkToCrud('Ville', 'fa fa-solid fa-city', Category::class);
        yield MenuItem::linkToCrud('Réservations', 'fa fa-solid fa-city', Reservation::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-solid fa-user', User::class);
        yield MenuItem::linkToCrud('Contacts', 'fa fa-solid fa-user', Liste::class);

        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
