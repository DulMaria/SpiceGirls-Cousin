<style>
    form {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        background-color: #f9f9f9;
        border: 1px solid #ddd;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: 'Segoe UI', sans-serif;
    }

    h2 {
        margin-bottom: 20px;
        font-size: 22px;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 12px;
        font-size: 16px;
        cursor: pointer;
        color: #444;
    }

    input[type="radio"] {
        margin-right: 10px;
    }

    button[type="submit"] {
        margin-top: 20px;
        background-color: #007bff;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>

<form method="POST" action="{{ route('test.guardar') }}">
    @csrf
    <h2><strong>{{ $pregunta['texto'] }}</strong></h2>
    <input type="hidden" name="index" value="{{ $index }}">

    @foreach ($pregunta['opciones'] as $opcion)
        <label>
            <input type="radio" name="respuesta" value="{{ $opcion }}" required> {{ $opcion }}
        </label><br>
    @endforeach

    <button type="submit">Siguiente</button>
</form>

