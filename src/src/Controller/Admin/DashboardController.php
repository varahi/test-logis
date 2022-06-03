<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Company;
use App\Entity\Delivery;
use App\Entity\Order;
use App\Entity\Location;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Test Admin Panel');
    }

    /*
    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
    */

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Back to the site', 'fa fa-home', 'app_home');

        yield MenuItem::section('Company and orders');
        yield MenuItem::subMenu('Company', 'fa fa-tags')->setSubItems([
            MenuItem::linkToCrud('Company list', 'fa fa-list', Company::class),
            MenuItem::linkToCrud('Order list', 'fa fa-th', Order::class),
        ]);

        yield MenuItem::section('Delivery and locations');
        yield MenuItem::subMenu('Delivery and locations', 'fa fa-wrench')->setSubItems([
            MenuItem::linkToCrud('Delivery list', 'fa fa-group', Delivery::class),
            MenuItem::linkToCrud('Location list', 'fa fa-file-text-o', Location::class),
        ]);
    }
}
