<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Entity\Course;
use App\Entity\Assignment;
use App\Entity\Category;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index (): Response
    {
        return parent::index();
    }

    public function configureDashboard (): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Administration');
    }

    public function configureMenuItems (): iterable
    {
        return [
            MenuItem::linktoDashboard('Dashboard', 'fa fa-home'),
            MenuItem::linkToCrud("Users", "fa fa-user", User::class),
            MenuItem::linkToCrud("Courses", "fas fa-chalkboard-teacher", Course::class),
            MenuItem::linkToCrud("Assignments", "fas fa-briefcase", Assignment::class),
            MenuItem::linkToCrud("Categories", "fab fa-slideshare", Category::class),
        ];
    }
}
