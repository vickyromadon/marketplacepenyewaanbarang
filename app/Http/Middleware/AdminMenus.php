<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMenus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        \Menu::make('MenuAdmin', function ($menu) {
            $menu->add('', ['class' => 'header']);
            // Dashboard
            $menu->add('<span>Dashboard</span>', ['route' => 'admin.home.index'])
                 ->prepend('<i class="fa fa-dashboard"></i>');

            // Profile
            if ( Auth::user() ) {
              $menu->add('<span>Profile</span>', ['route' => ['admin.home.profile', 'id' => Auth::user()->id]])
                 ->prepend('<i class="fa fa-user"></i>');
            }

            // Management User
            $menuUser = $menu->add('<span>Management User</span>', ['url' => '#','class' => 'treeview'])
                           ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>')
                           ->prepend('<i class="fa fa-users"></i>');
            $menuUser->add('<span>Member</span>', ['route' => 'members.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>');
            $menuUser->add('<span>Owner</span>', ['route' => 'owners.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>');

            // Product
            $menu->add('<span>Management Product</span>', ['route' => 'product.index'])
                 ->prepend('<i class="fa fa-cubes"></i>');

            // Bank
            $menu->add('<span>Bank</span>', ['route' => 'bank.index'])
                 ->prepend('<i class="fa fa-bank"></i>');

            // Management Category
            $menuUser = $menu->add('<span>Management Category</span>', ['url' => '#','class' => 'treeview'])
                           ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>')
                           ->prepend('<i class="fa fa-th-list"></i>');
            $menuUser->add('<span>Category</span>', ['route' => 'category.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>');
            $menuUser->add('<span>Sub Category</span>', ['route' => 'sub_category.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>');

            // Courier
            // $menu->add('<span>Courier</span>', ['route' => 'courier.index'])
            //      ->prepend('<i class="fa fa-truck"></i>');

            // Faq
            $menu->add('<span>FAQ</span>', ['route' => 'faq.index'])
                 ->prepend('<i class="fa fa-question"></i>');

            // Messages
            $menu->add('<span>Messages</span>', ['route' => 'message.index'])
                 ->prepend('<i class="fa fa-comments-o"></i>');

            // Company Profile
            $menu->add('<span>Company Profile</span>', ['route' => 'company_profile.index'])
                 ->prepend('<i class="fa fa-building-o"></i>');

            // Rekber
            $menuRekber = $menu->add('<span>REKBER</span>', ['url' => '#','class' => 'treeview'])
                           ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>')
                           ->prepend('<i class="fa fa-circle-o text-red"></i>');
            $menuRekber->add('<span>Transaction</span>', ['route' => 'transaction_rekber.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>');
            $menuRekber->add('<span>Payment Confirmation</span>', ['route' => 'payment_confirmation.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>')
                   ->prepend('<span class="pull-right-container">
                        <small id="transactionPaymentAdmin" class="label pull-right bg-blue"></small>
                    </span>');

            $menuRekber->add('<span>Refund</span>', ['route' => 'refund.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>')
                   ->prepend('<span class="pull-right-container">
                        <small id="refundAdmin" class="label pull-right bg-yellow"></small>
                    </span>');  

            // COD
            $menuCod = $menu->add('<span>COD</span>', ['url' => '#','class' => 'treeview'])
                           ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>')
                           ->prepend('<i class="fa fa-circle-o text-blue"></i>');
            $menuCod->add('<span>Transaction</span>', ['route' => 'transaction_cod.index'])
                   ->prepend('<i class="fa fa-circle-o"></i>');          

        });

        return $next($request);
    }
}
