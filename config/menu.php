<?php

use Spatie\Menu\Laravel\Menu;
use Spatie\Menu\Laravel\Html;
use Spatie\Menu\Laravel\Link;
use Acoustep\EntrustGui\Http\Controllers;

Menu::macro('adminlteSubmenu', function ($submenuName) {
    return Menu::new()->prepend('<a href="#"><span> ' . $submenuName . '</span> <i class="fa fa-angle-left pull-right"></i></a>')
        ->addParentClass('treeview')->addClass('treeview-menu');
});

Menu::macro('adminlteMenu', function () {
    return Menu::new()
        ->addClass('sidebar-menu')->setAttribute('data-widget','tree');
});

Menu::macro('adminlteSeparator', function ($title) {
    return Html::raw($title)->addParentClass('header');
});

Menu::macro('adminlteDefaultMenu', function ($content,$ico) {
    return Html::raw('<i class="fa ' . $ico. '"></i><span>' . $content . '</span>')->html();
});

Menu::macro('sidebar', function () {
    return Menu::adminlteMenu()
        ->add(Html::raw('HEADER')->addParentClass('header'))
        ->action('PersonsController@index', '<i class="fa fa-users"></i><span>'. trans('menu.persons') .'</span>')
        ->action('PaymentsController@index', '<i class="fa fa-money"></i><span>'. trans('menu.payments') .'</span>')
        ->action('PropertiesController@index', '<i class="fa fa-home"></i><span>'.trans('menu.properties').'</span>')
        ->add(Menu::new()->prepend('<a href="#"><i class="fa fa-book"></i><span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>')
            ->addParentClass('treeview')
            ->action('ReportsController@getPaymentsIndex', '<i class="fa fa-money"></i><span>Pagos</span>')
            ->action('ReportsController@getPortfolioReceivableIndex', '<i class="fa fa-money"></i><span>Cartera</span>')
            ->action('    ', '<i class="fa fa-money"></i><span>Datos Empresa</span>')
            ->addClass('treeview-menu')
        )
        ->setActiveFromRequest();
});


Menu::macro('sidebarAdmin', function () {
    return Menu::adminlteMenu()
        ->add(Html::raw('HEADER')->addParentClass('header'))
        ->action('PersonsController@index', '<i class="fa fa-users"></i><span>'. trans('menu.persons') .'</span>')
        ->action('PaymentsController@index', '<i class="fa fa-money"></i><span>'. trans('menu.payments') .'</span>')
        ->action('PropertiesController@index', '<i class="fa fa-home"></i><span>'.trans('menu.properties').'</span>')
        ->add(Menu::new()->prepend('<a href="#"><i class="fa fa-book"></i><span>Reportes</span> <i class="fa fa-angle-left pull-right"></i></a>')
            ->addParentClass('treeview')
            ->action('ReportsController@totalPayments', '<i class="fa fa-money"></i><span>Pagos</span>')
            ->action('ReportsController@totalPorfolioReceivable', '<i class="fa fa-money"></i><span>Cartera</span>')
            ->addClass('treeview-menu')
        )
        ->add(Menu::new()->prepend('<a href="#"><i class="fa fa-lock"></i><span>Seguridad</span> <i class="fa fa-angle-left pull-right"></i></a>')
            ->addParentClass('treeview')
            ->add(Link::to('/admin/users', 'Usuarios'))
            ->add(Link::to('/admin/roles', 'Roles'))
            ->addClass('treeview-menu')
        )
        ->setActiveFromRequest();
});
