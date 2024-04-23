<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('search');

        $customers = Customer::where(function ($q) use ($query) {
            $q->where('name', 'like', "%$query%")
                ->orWhere('email', 'like', "%$query%")
                ->orWhere('dni', 'like', "%$query%")
                ->orWhere('telephone', 'like', "%$query%");
        })
            ->paginate(10);

        return view('customers.index', compact('customers'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customers.index');
    }
}
