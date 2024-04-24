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
     * Edit the specified resource from storage
     */
    public function edit($id)
    {
        // Find the client by ID
        $customers = Customer::findOrFail($id);

        // Retorna la vista de edición con el cliente encontrado
        return view('customers.modify', compact('customers'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos recibidos del formulario
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:customers,email,' . $id,
            'dni' => 'required',
            'telephone' => 'nullable',
        ]);

        // Obtener el cliente por su ID
        $customers = Customer::findOrFail($id);

        // Actualizar los datos del cliente con los datos del formulario
        $customers->update($request->all());

        // Redirigir al usuario de vuelta a la página de índice de clientes
        return redirect()->route('customers.index');
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
