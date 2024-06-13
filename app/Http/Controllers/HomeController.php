<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Shipping;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cant_users = User::count();
        $cant_roles = Role::count();
        $cant_products = Product::count();
        $cant_providers = Provider::count();
        $cant_shipping_services = Shipping::count();

        return view('home', compact('cant_users', 'cant_roles', 'cant_products', 'cant_providers', 'cant_shipping_services'));
    }
}
