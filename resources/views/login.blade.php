<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BH Cabinetry</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Google Fonts: Inter & Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Shared theme styles */
        body {
            background-color: #F8F7F4; /* Lightest brown background */
            font-family: 'Inter', sans-serif;
            color: #333333;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 500;
        }
        .text-accent { color: #E86A33; }
        .btn-minimal {
            background-color: #2D2D2D;
            color: white;
            transition: background-color 0.3s;
        }
        .btn-minimal:hover {
            background-color: #000000;
        }
        .border-secondary { border-color: #EAEAEA; }
        
        /* Form Input Styles */
        .form-input {
            background-color: #FFFFFF;
            border: 1px solid #EAEAEA;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            transition: border-color 0.3s, box-shadow 0.3s;
            width: 100%;
        }
        .form-input:focus {
            outline: none;
            border-color: #2D2D2D;
            box-shadow: 0 0 0 2px rgba(45, 45, 45, 0.2);
        }
    </style>
</head>
<body class="bg-[#F8F7F4]">

    <div class="flex min-h-full items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md space-y-8">
            <div>
                <a href="{{ route('home') }}" class="text-3xl font-bold mx-auto h-12 w-auto text-center block">BH CABINETRY</a>
                <h2 class="mt-6 text-center text-3xl font-semibold text-gray-900">Welcome Back</h2>
                 <p class="mt-2 text-center text-sm text-gray-600">
                    Sign in to continue to your account.
                </p>
            </div>
            <form class="mt-8 space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div>
                        <label for="email-address" class="sr-only">Email address</label>
                        <input id="email-address" name="email" type="email" autocomplete="email" required class="form-input rounded-b-none @error('email') border-red-500 @enderror" placeholder="Email address" value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="password" class="sr-only">Password</label>
                        <input id="password" name="password" type="password" autocomplete="current-password" required class="form-input rounded-t-none @error('password') border-red-500 @enderror" placeholder="Password">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember" type="checkbox" class="h-4 w-4 text-accent focus:ring-accent/50 border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-gray-900">Remember me</label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-medium text-accent hover:text-accent/80">Forgot your password?</a>
                    </div>
                </div>

                <div>
                    <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-black focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        Sign in
                    </button>
                </div>

                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="font-medium text-accent hover:text-accent/80">Sign up</a>
                    </p>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            lucide.createIcons();
        });
    </script>
</body>
</html> 