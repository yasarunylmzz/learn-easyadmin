<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\UserCrudController;
use App\Controller\Admin\BlogPostCrudController;
use App\Controller\Admin\CategoryCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use Symfony\Component\Security\Core\User\UserInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{

    public function __construct(private ChartBuilderInterface $chartBuilder) {}
    public function index(): Response
    {

        $chart = $this->chartBuilder->createChart(Chart::TYPE_LINE);

        return $this->render('admin/my-dashboard.html.twig', [
            'chart' => $chart,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Learn Easyadmin');
    }

    public function configureMenuItems(): iterable
    {

        return [
            MenuItem::linkToDashboard('Home', 'fa fa-home'),

            MenuItem::section('Blog Posts', 'fa fa-newspaper-o'),
                MenuItem::linkTo(CategoryCrudController::class, 'Categories', 'fa fa-tags'),
                MenuItem::linkTo(BlogPostCrudController::class, 'Posts', 'fa fa-file-text'),
                MenuItem::linkTo(TagCrudController::class, 'Tags', 'fa fa-tags'),

            MenuItem::section('Users'),
            // MenuItem::linkTo(CommentCrudController::class, 'Comments', 'fa fa-comment'),
                MenuItem::linkTo(UserCrudController::class, 'Users', 'fa fa-user'),
                MenuItem::linkTo(CategoryCrudController::class, 'categories', 'fa fa-tags'),

            MenuItem::linkToLogout('Logout', 'fa fa-exit')

        ];
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        return parent::configureUserMenu($user)
            // ->setName($user->getFullName())
            ->displayUserName(false)
            ->displayUserAvatar(false)
            ->disableLogoutLink()

            // you can use any type of menu item, except submenus
            ->addMenuItems([
                MenuItem::linkToRoute('My Profile', 'fa fa-id-card', 'admin_profile'),
                MenuItem::linkToRoute('Settings', 'fa fa-user-cog', '...', ['...' => '...']),
                MenuItem::section(),
                MenuItem::linkToLogout('Logout', 'fa fa-sign-out'),
            ]);
    }
}
