<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Pharmacy System</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8">

    <div class="max-w-4xl w-full bg-white rounded-lg shadow-md overflow-hidden grid md:grid-cols-2">
        <!-- Left side / Image -->
        <div class="hidden md:block bg-teal-500 p-8 flex flex-col justify-center">
            <div class="text-center">
                <h1 class="text-white text-3xl font-bold mb-4">Pharmacy System</h1>
                <p class="text-teal-100 mb-6">Manage your pharmacy operations efficiently</p>
                <div class="w-24 h-1 bg-white mx-auto"></div>
            </div>
        </div>

        <!-- Right side / Form -->
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Sign In</h2>
            <p class="text-gray-600 mb-6">Welcome back! Please enter your details</p>

            @if (session('status'))
                <div class="mb-4 p-3 text-sm text-green-700 bg-green-100 border border-green-300 rounded">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm"
                        placeholder="Enter your email" />
                </div>

                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm"
                        placeholder="Enter your password" />
                </div>

                

                <button type="submit"
                    class="w-full bg-teal-600 text-white py-2 px-4 rounded-md hover:bg-teal-700 transition duration-200">
                    Login
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-teal-600 hover:underline">Register here</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>
