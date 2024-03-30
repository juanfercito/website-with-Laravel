<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductClass;
use App\Models\ProductType;
use Illuminate\Http\Request;


class RelationshipController extends Controller
{

    public function index()
    {
        $products = Product::all();
        return view("products.index", compact("products"));
    }
}
