<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Provider;

class ProviderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:watch-providers|insert-provider|modify-provider|delete-provider', ['only' => ['index']]);
        $this->middleware('permission:insert-provider', ['only' => ['create', 'store']]);
        $this->middleware('permission:modify-provider', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-provider', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $providers = Provider::paginate(5);
        return view('providers.index', compact('providers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('providers.insert');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'provider_class_id' => 'required',
            'provider_category_id' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'location' => 'required',
            'closing_order_date' => 'required',
            'application_date' => 'required',
        ]);

        $provider = $validatedData; // Utilizar los datos validados

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/provider_img', $imageName); // Guardar la imagen en la carpeta storage/app/public/provider_img
            $provider['image'] = $imageName; // Asignar el nombre de la imagen al arreglo $provider
        }

        Provider::create($provider);
        return redirect()->route('providers.index');
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
    public function edit(Provider $provider)
    {
        return view('providers.modify', compact('provider'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Provider $provider)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'provider_class_id' => 'required',
            'provider_category_id' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,svg|max:1024',
            'location' => 'required',
            'closing_order_date' => 'required',
            'application_date' => 'required',
        ]);

        // Si la imagen no se cambia, no es necesaria
        if (!$request->hasFile('image')) {
            unset($validatedData['image']);
        }

        $provider->update($validatedData);

        return redirect()->route('providers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Provider $provider)
    {
        $provider->delete();
        return redirect()->route('providers.index');
    }
}
