<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmation</title>
</head>

<body>
    <h2>Confirmación</h2>
    <p>Los datos ya existen. ¿Desea usarlos para emitir una factura?</p>
    <form action="{{ route('customers.confirmation.process') }}" method="post">
        @csrf
        <input type="hidden" name="customerId" value="{{ $customer->id }}">
        <label for="name">Nombre</label>
        <input type="text" id="name" name="name" value="{{ $customer->name }}" readonly><br>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ $customer->email }}" readonly><br>
        <label for="dni">DNI</label>
        <input type="text" id="dni" name="dni" value="{{ $customer->dni }}" readonly><br>
        <label for="telephone">Teléfono</label>
        <input type="text" id="telephone" name="telephone" value="{{ $customer->telephone }}" readonly><br>
        <button type="submit" name="action" value="confirm">Sí</button>
        <button type="submit" name="action" value="cancel">No</button>
    </form>
</body>

</html>