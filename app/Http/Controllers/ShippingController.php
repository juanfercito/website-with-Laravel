<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Shipping;

class ShippingController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:watch-shipping|insert-shipping|modify-shipping|delete-shipping', ['only' => ['index']]);
        $this->middleware('permission:insert-shipping', ['only' => ['create', 'store']]);
        $this->middleware('permission:modify-shipping', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-shipping', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shippings = Shipping::paginate(10); // Aquí obtienes los datos de envío de la base de datos
        return view('shipping.index', compact('shippings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
