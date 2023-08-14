@extends('layouts.app')

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión - Mi aplicación</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="items-center justify-center  from-gray-800 via-greeen-600 to-blue-500 bg-gradient-to-br">
  <div class="min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-lg shadow-lg">
      <div class="flex justify-center mb-8">
        <img src="{{ asset('iconic.jpg') }}" alt="Logo" class="w-30 h-20">
      </div>
      <h1 class="text-2xl font-semibold text-center text-gray-500 mt-8 mb-6">Iniciar sesión</h1>
      <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-6">
          <label for="email" class="block mb-2 text-sm text-gray-600">Correo electrónico</label>
          <input id="email" type="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
          @error('email')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="mb-6">
          <label for="password" class="block mb-2 text-sm text-gray-600">Contraseña</label>
          <input type="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-cyan-500" @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
          <a href="#" class="block text-right text-xs text-cyan-600 mt-2">¿Olvidaste tu contraseña?</a>
          @error('password')
          <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <button type="submit" class="w-32 bg-blue-500 py-2 rounded-lg mx-auto block mt-4 mb-6">Acceso</button>
      </form>
      <div class="text-center">
        <p class="text-sm">¿No tienes una cuenta? <a href="{{ route('register') }}" class="text-cyan-600">Regístrate ahora</a></p>
      </div>
      <p class="text-xs text-gray-600 text-center mt-10">&copy; 2023</p>
    </div>
  </div>
</body>
</html>
