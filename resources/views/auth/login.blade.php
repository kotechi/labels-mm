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

<body class="flex items-center justify-center min-h-screen bg-gradient-to-b from-[#C890AF] to-[#6A1E55]">
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
                                required
                            >
                        </div>
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
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
</body>
</html>