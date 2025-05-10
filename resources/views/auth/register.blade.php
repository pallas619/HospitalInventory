<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Pharmacy System</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4 py-8">

    <div class="max-w-4xl w-full bg-white rounded-lg shadow-md overflow-hidden grid md:grid-cols-2">
        <!-- Left side / Info -->
        <div class="hidden md:block bg-teal-500 p-8 flex flex-col justify-center">
            <div class="text-center">
                <h1 class="text-white text-3xl font-bold mb-4">Join Our System</h1>
                <p class="text-teal-100 mb-6">Create an account to access the pharmacy management tools</p>
                <div class="w-24 h-1 bg-white mx-auto"></div>
            </div>
        </div>

        <!-- Right side / Form -->
        <div class="p-8">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Create Account</h2>
            <p class="text-gray-600 mb-6">Please complete the form below to register</p>

            @if ($errors->any())
                <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-300 rounded">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block mb-1 text-sm font-medium text-gray-700">Full Name</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm"
                        placeholder="Enter your full name" />
                </div>

                <div>
                    <label for="email" class="block mb-1 text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm"
                        placeholder="Enter your email address" />
                </div>

                <div>
                    <label for="password" class="block mb-1 text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm"
                        placeholder="Create a password" />
                </div>

                <div>
                    <label for="password_confirmation" class="block mb-1 text-sm font-medium text-gray-700">Confirm
                        Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm"
                        placeholder="Confirm your password" />
                </div>

                <div>
                    <label for="role" class="block mb-1 text-sm font-medium text-gray-700">Role</label>
                    <select name="role" id="role" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-teal-500 focus:border-teal-500 text-sm">
                        <option value="">-- Select Role --</option>
                        <option value="Pharmacist" {{ old('role') == 'Pharmacist' ? 'selected' : '' }}>Pharmacist
                        </option>
                        <option value="Technician" {{ old('role') == 'Technician' ? 'selected' : '' }}>Technician
                        </option>
                    </select>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-teal-600 text-white py-2 px-4 rounded-md hover:bg-teal-700 transition duration-200">
                        Register
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Already have an account?
                    <a href="{{ route('login') }}" class="text-teal-600 hover:underline">Sign in</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>
