<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class OwnerMenus
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
        \Menu::make('MenuOwner', function ($menu) {
            $menu->add('', ['class' => 'header']);
            // Dashboard
            $menu->add('<span>Dashboard</span>', ['route' => 'owner.home.index'])
                 ->prepend('<i class="fa fa-dashboard"></i>');

            // Profile
            if ( Auth::user() ) {
                $menu->add('<span>Profile</span>', ['route' => ['owner.home.profile', 'id' => Auth::user()->id]])
                  ->prepend('<i class="fa fa-user"></i>');
            }

            // Bank
            $menu->add('<span>Bank</span>', ['route' => 'owner.bank.index'])
                 ->prepend('<i class="fa fa-bank"></i>');

            // Product
            $menuProduct = $menu->add('<span>Product</span>', ['url' => '#','class' => 'treeview'])
                           ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>')
                           ->prepend('<i class="fa fa-cubes"></i>');
            $menuProduct->add('<span>List Product</span>', ['route' => 'owner.product.index'])
                   ->prepend('<i class="fa fa-tasks"></i>');
            $menuProduct->add('<span>Add Product</span>', ['route' => 'owner.product.store'])
                   ->prepend('<i class="fa fa-plus"></i>');

            // Booking
            $menu->add('<span>Booking</span>', ['route' => 'owner.booking.index'])
                 ->prepend('<i class="fa  fa-shopping-cart"></i>')
                 ->prepend('<span class="pull-right-container">
                        <small id="bookingOwner" class="label pull-right bg-red"></small>
                    </span>');

            // Transaction
            $menuTransaction = $menu->add('<span>Transaction</span>', ['url' => '#','class' => 'treeview'])
                           ->append('<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>')
                           ->prepend('<i class="fa fa-money"></i>');
            $menuTransaction->add('<span>REKBER</span>', ['route' => 'owner.transaction.index'])
                 ->prepend('<i class="fa fa-circle-o"></i>')
                 ->prepend('<span class="pull-right-container">
                        <small id="transactionRekberOwner" class="label pull-right bg-orange"></small>
                    </span>');
            $menuTransaction->add('<span>COD</span>', ['route' => 'owner.cod.index'])
                ->prepend('<i class="fa fa-circle-o"></i>')
                ->prepend('<span class="pull-right-container">
                        <small id="transactionCodOwner" class="label pull-right bg-aqua"></small>
                    </span>');    

            // Payment Confirmation
            $menu->add('<span>Payment Confirmation</span>', ['route' => 'owner.payment_confirmation.index'])
                 ->prepend('<i class="fa fa-cc-mastercard"></i>');

            // Delivery
            $menu->add('<span>Delivery</span>', ['route' => 'owner.delivery.index'])
                 ->prepend('<i class="fa fa-truck"></i>')
                 ->prepend('<span class="pull-right-container">
                        <small id="deliveryOwner" class="label pull-right bg-blue"></small>
                    </span>');

            // Reversion
            $menu->add('<span>Reversion</span>', ['route' => 'owner.reversion.index'])
                 ->prepend('<i class="fa fa-fast-backward"></i>')
                 ->prepend('<span class="pull-right-container">
                        <small id="reversionOwner" class="label pull-right bg-purple"></small>
                    </span>');

            // Refund
            $menu->add('<span>Refund</span>', ['route' => 'owner.refund.index'])
                 ->prepend('<i class="fa fa-dollar"></i>')
                 ->prepend('<span class="pull-right-container">
                        <small id="refundOwner" class="label pull-right bg-yellow"></small>
                    </span>');         
        });
        return $next($request);
    }
}
