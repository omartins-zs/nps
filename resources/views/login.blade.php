<!-- resources/views/login.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Laravel</title>

    <!-- Fonts e Estilos -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased flex items-center justify-center min-h-screen">
    <div class="max-w-sm w-full p-6 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center mb-6">Login</h2>
        <form class="mb-4">
            <div class="mb-5">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                <input type="email" id="email" placeholder="name@example.com" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            <div class="mb-5">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Senha</label>
                <input type="password" id="password" required
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" />
            </div>
            <div class="flex items-start mb-5">
                <input id="remember" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500" />
                <label for="remember" class="ml-2 text-sm text-gray-900">Lembrar-me</label>
            </div>
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg">
                Entrar
            </button>
        </form>

        <div class="text-center text-sm text-gray-600 mb-4">ou entre com</div>

        <!-- Botões de login social -->
        <div class="flex flex-col gap-2">
            <a href="" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 11.1h9.6v1.8H12v-1.8z"/></svg>
                Entrar com Google
            </a>
            <a href="" class="w-full bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path fill="currentColor" d="M12 11.1h9.6v1.8H12v-1.8z"/></svg>
                Entrar com Laravel
            </a>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</body>
</html>
