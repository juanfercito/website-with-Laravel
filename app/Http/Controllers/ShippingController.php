<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $shippings = Shipping::paginate(5);
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
            'shipping_route_id' => 'required',
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
            $saveImgRoute = 'shipping-img/';
            $shippingImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($saveImgRoute, $shippingImg);
            $shippingData['image'] = $shippingImg;
        }

        // create the shipping service with the form data
        $shipping = Shipping::create($shippingData);

        // Update the tables relationship
        $shipping->shipping_service_type_id = $request->shipping_service_type_id;
        $shipping->shipping_route_id = $request->shipping_route_id;

        // Save the shipping service and its relations
        $shipping->save();

        return redirect()->route('shippings.index');
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
    public function edit(Shipping $shipping)
    {
        return view('shipping.modify', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipping $shipping)
    {
        // Validating the required fields
        $request->validate([
            'name' => 'required',
            'shipping_service_type_id' => 'required',
            'shipping_route_id' => 'required',
            'description' => 'required',
            'weight_cost' => 'required',
            'size_cost' => 'required',
            'total_cost' => 'required',
            'estimated_delivery_time' => 'required',
        ]);

        // Validating image onli if upload a new image
        if ($request->hasFile('image')) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,svg|max:1024',
            ]);

            // Guardar la nueva imagen
            $saveImgRoute = 'shipping-img/';
            $shippingImg = date('YmdHis') . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move($saveImgRoute, $shippingImg);

            // Asignar la nueva imagen al producto
            $shipping->image = $shippingImg;
        }

        // Update the product data
        $shipping->update($request->except('image'));

        // Updating the product relations with tables
        $shipping->shipping_service_type_id = $request->shipping_service_type_id;
        $shipping->shipping_route_id = $request->shipping_route_id;

        // Save the changes
        $shipping->save();

        return redirect()->route('shippings.index');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Shipping $shipping)
    {
        // Verificar si la imagen existe y eliminarla
        if (Storage::exists('shipping-img/' . $shipping->image)) {
            Storage::delete('shipping-img/' . $shipping->image);
        }

        // Eliminar el envío
        $shipping->delete();

        return redirect()->route('shippings.index');
    }
}
