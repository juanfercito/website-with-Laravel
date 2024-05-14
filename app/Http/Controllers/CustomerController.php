<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function create()
    {
        return view('customers.insert');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email',
            'dni' => 'required|unique:customers,dni',
            'telephone' => 'nullable',
        ]);

        // Crear un nuevo cliente con los datos validados
        $customer = Customer::create($validatedData);

        // Verifica si el cliente se creó correctamente
        if ($customer) {
            // Coloca el dd(session('customer')); aquí para verificar la sesión antes de la redirección
            dd(session('customer'));

            // Redirigir al usuario a la página de inserción de ventas y pasar los datos del cliente
            return redirect()->route('customers.index')->with('customers', $customer);
        } else {
            // Si hay un problema al crear el cliente, redirige con un mensaje de error
            return redirect()->back()->with('error', 'Error al crear el cliente');
        }
    }



    public function edit($id)
    {
        // Find the client by ID
        $customer = Customer::findOrFail($id);

        // Retorna la vista de edición con el cliente encontrado
        return view('customers.modify', compact('customers'));
    }

    public function update(Request $request, $id)
    {
        // Obtener el cliente por su ID
        $customer = Customer::findOrFail($id);

        // Si hay cambios en los datos, realiza la validación y la actualización
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $customer->id,
            'dni' => 'required|unique:customers,dni,' . $customer->id,
            'telephone' => 'nullable',
        ]);

        $customer->update($validatedData);

        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        Customer::find($id)->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully');
    }

    public function searchByDni(Request $request)
    {
        $dni = $request->get('dni');
        $customer = Customer::where('dni', $dni)->first();

        if ($customer) {
            return response()->json(['success' => true, 'name' => $customer->name, 'email' => $customer->email, 'telephone' => $customer->telephone]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /*
    * Additional methods for getting customers
    */
    public function useExistingData(Request $request)
    {
        $customer = Customer::findOrFail($request->customer_id);

        Session::put('customerData', $customer);

        return redirect()->route('sales.create')->with('success', 'Customer data loaded successfully');
    }
}
