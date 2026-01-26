<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suma de 2 números</title>
</head>

<body>
    <h2>Sumar 2 números</h2>
    <form action="/suma" method="POST">
        <!-- Complemento de seguridad -->
        @csrf
        <!-- Fin complemento de seguridad -->
        <label for="numero1">Número 1:</label>
        <input type="number" name="numero1" id="numero1" required>
        <br>

        <label for="numero2">Número 2:</label>
        <input type="number" name="numero2" id="numero2" required>
        <br>

        <button type="submit">Calcular</button>
    </form>
    <br>
    @if(isset($resultado))

        <h3>Resultado de la suma: {{ $resultado }}</h3>

    @endif
</body>

</html>