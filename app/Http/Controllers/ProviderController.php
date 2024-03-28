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
        request()->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,svg|max:1024',
            'location' => 'required',
            'closing-order-date' => 'required',
            'application-date' => 'required',
        ]);

        $provider = $request->all();
        if ($image = $request->file('image')) {
            $saveImgRoute = 'provider-img/';
            $providerImg = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($saveImgRoute, $providerImg);
            $provider['image'] = $providerImg;
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
        request()->validate([
            'name' => 'required',
            'category' => 'required',
            'description' => 'required',
            'image' => 'required',
            'location' => 'required',
            'closing-order-date' => 'required',
            'application-date' => 'required',
        ]);
        $provider->update($request->all());
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
