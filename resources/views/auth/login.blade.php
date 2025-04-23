<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Poppins', serif; }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen bg-gradient-to-b from-[#5A074C] to-[#FF00CA]">
    <div class="container flex flex-col items-center justify-center min-h-screen">
        <h2 class="text-4xl font-extrabold text-white mb-8 mt-5 drop-shadow-[1px_9px_2px_rgba(0,0,0,0.3)]">
            Welcome to LabelsMM
        </h2>
        <div class="flex w-full max-w-4xl bg-white rounded-lg shadow-lg">
            <!-- Logo Section -->
            <div class="w-1/2 flex items-center justify-center bg-white shadow-lg mt-1 p-16">
                <img src="{{ asset('storage/images/icon/LAblesMM.png') }}" alt="Logo" class="p-3 max-w-full rounded-xl border-2 border-pink-200 shadow-[0_6px_15px_rgba(0,0,0,0.6)]">
            </div>

            <!-- Form Section -->
            <div class="w-1/2 p-8 bg-white">
                <h2 class="text-3xl font-bold text-center text-[#00000] mb-8"><u>Agent Login</u></h2>
                <form method="POST" action="{{ route('login') }}" onsubmit="this.querySelector('button[type=submit]').disabled = true;" class="mt-4 space-y-6">
                    @csrf
                    
                    <!-- Username Input -->
                    <div class="relative">
                        <div class="flex items-center border rounded-md border-[#6A1E55] px-3 py-3 bg-[#FFF0F0] focus-within:ring-2 focus-within:ring-purple-500">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 10a4 4 0 100-8 4 4 0 000 8zm-7 8a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input 
                                type="text" 
                                id="username" 
                                name="username" 
                                class="w-full outline-none ml-2 bg-[#FFF0F0] placeholder-black placeholder-opacity-100"
                                placeholder="Masukkan username Anda"
                                value="{{ old('username') }}"
                                required 
                                autofocus
                            >
                        </div>
                        @error('username')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password Input -->
                    <div class="relative">
                        <div class="flex items-center border rounded-md border-[#6A1E55] px-3 py-3 bg-[#FFF0F0] focus-within:ring-2 focus-within:ring-purple-500">
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path fill-rule="evenodd" d="M12 2a5 5 0 00-5 5v3H6a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2h-1V7a5 5 0 00-5-5zm-3 5a3 3 0 016 0v3H9V7zm3 6a1.5 1.5 0 100 3 1.5 1.5 0 000-3z" clip-rule="evenodd" />
                                </svg>
                            </span>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="w-full outline-none ml-2 bg-[#FFF0F0] placeholder-black placeholder-opacity-100"
                                placeholder="Masukkan password Anda"
                                value="{{ old('password') }}"
                                required
                            >
                            <button 
                                type="button" 
                                id="togglePassword" 
                                class="text-gray-500 focus:outline-none"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" id="eyeIcon">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden" viewBox="0 0 20 20" fill="currentColor" id="eyeOffIcon">
                                    <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                    <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="flex items-center">
                        <input 
                            type="checkbox" 
                            id="remember" 
                            name="remember" 
                            class="h-4 w-4 text-purple-600 border-gray-300 rounded focus:ring-purple-500"
                            {{ old('remember') ? 'checked' : '' }}
                        >
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Remember Me</label>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        class="w-full px-1 py-3 text-white bg-[#9B1473] rounded-md hover:bg-[#C890A7] border border-black focus:outline-none focus:ring-2 focus:ring-purple-500"
                    >
                        Sign Up
                    </button>

                    <!-- Footer -->
                    <p class="text-xs text-center text-gray-500 mt-8">Copyright @ LabelsMM 2024 | Privacy Policy</p>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');
            const eyeOffIcon = document.getElementById('eyeOffIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        });
    </script>
</body>
</html>