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
        return view('shipping.insert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate([
            'name' => 'required',
            'shipping_service_type_id' => 'required',
            'shipping_routes_id' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'weight_cost' => 'required',
            'size_cost' => 'required',
            'total_cost' => 'required',
            'estimated_delivery_time' => 'required',
        ]);

        // getting all form data
        $shippingData = $request->all();
        if ($image = $request->file('image')) {
            $saveImgRoute = 'shipping-service-img/';
            $shippingImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($saveImgRoute, $shippingImg);
            $shippingData['image'] = $shippingImg;
        }

        // create the shipping service with the form data
        $shipping = Shipping::create($shippingData);

        // Update the tables relationship
        $shipping->shipping_service_type_id = $request->shipping_service_type_id;
        $shipping->shipping_routes_id = $request->shipping_routes_id;

        // Save the shipping service and its relations
        $shipping->save();

        return redirect()->route('shipping.index');
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
