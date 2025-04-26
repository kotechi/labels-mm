<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Labels-MM</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/icon/logo.jpg') }}" alt="Logo">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<style>
    .bg-labels {
        background-color: #9A1573;
    }
    .text-color-labels {
        color: #9A1573;
    }

</style>
<body class="font-sans antialiased bg-purple-50">
    <nav class="bg-amber-50 py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="flex items-center">
                <img src="{{ asset('storage/images/icon/logo.jpg') }}" alt="Logo" class="mr-2 w-14">
                <span class="font-bold text-lg">Labels - MM</span>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="#" class="text-gray-800 hover:text-color-labels">HOME</a>
                <a href="#about" class="text-gray-800 hover:text-color-labels">ABOUT</a>
                <a href="#gallery" class="text-gray-800 hover:text-color-labels">GALLERY</a>
                <a href="#contact" class="text-gray-800 hover:text-color-labels">CONTACT</a>
            </div>
        </div>
    </nav>
    <div class="bg-amber-50 py-12 relative overflow-hidden">
        <div class="container mx-auto px-4">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 flex justify-center">
                    <img src="{{ asset('storage/' . $headers->image) }}" alt="Fashion Display" class="rounded-lg shadow-lg w-80">
                </div>
                <div class="md:w-1/2 mb-8 md:mb-0">
                    <h2 class="text-purple-800 font-bold text-xl mb-2">WELCOME TO</h2>
                    <h1 class="text-purple-800 font-bold text-3xl mb-4">{{$headers->tittle}}</h1>
                    <p class="text-gray-700 mb-6">
                        {{$headers->description}}
                    </p>
                    <button class="bg-purple-700 text-white px-6 py-2 rounded-lg hover:bg-purple-800 transition">Learn More</button>
                </div>

            </div>
        </div>

        <div class="absolute bottom-0 right-0">
            <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M150 0C150 82.8427 82.8427 150 0 150V0H150Z" fill="#9333EA" fill-opacity="0.1"/>
            </svg>
        </div>
    </div>

    <div id="about" class="py-16 bg-white relative">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-purple-800 font-bold text-2xl mb-10">About Us</h2>
            
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <div class="md:w-2/3 pr-0 md:pr-8 mb-8 md:mb-0">
                    <h3 class="text-purple-800 font-semibold text-xl mb-4">{{$abouts->tittle}}</h3>
                    
                    <div class="mb-4">
                        <div class="flex items-start mb-2">
                            <div>
                                <p class="text-gray-600 text-md">{{$abouts->deskripsi}}</p>
                            </div>
                        </div>
                    </div>

                    
                    <button class="bg-purple-700 text-white px-6 py-2 rounded-lg hover:bg-purple-800 transition mt-4">Read More</button>
                </div>
                
                <div class="md:w-1/3 flex justify-center">
                    <img src="{{ asset('storage/' . $abouts->image) }}" alt="Model" class="rounded-full shadow-lg">
                </div>
            </div>
        </div>
        
        <div class="absolute bottom-0 left-0">
            <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 150C0 67.1573 67.1573 0 150 0V150H0Z" fill="#9333EA" fill-opacity="0.1"/>
            </svg>
        </div>
    </div>

    <div id="gallery" class="py-16 bg-purple-50">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-purple-800 font-bold text-2xl mb-2">Gallery</h2>
            <p class="text-center text-gray-600 mb-10">Some of our products</p>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($products as $product)
                <div class="bg-white p-4 rounded-lg shadow-md">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product 1" class="w-full h-auto rounded-md mb-2">
                    <h4 class="font-medium text-center text-sm">{{$product->nama_produk}}</h4>
                    <p class="text-center text-purple-700 font-semibold text-sm">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="contact" class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-purple-800 font-bold text-2xl mb-10">Contact</h2>
            
            <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
                <h3 class="font-semibold mb-4 text-center">Form Contact</h3>
                
                <form id="contactForm" action="{{ route('contact.lp.store')}}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                        <input type="text" name="nama" id="nama" placeholder="Enter your name" class="p-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" id="email" placeholder="Enter your email" class="p-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500" required>
                    </div>
                    
                    <div class="mb-6">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                        <textarea name="message" id="message" placeholder="Enter your message" rows="4" class="p-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-purple-500" required></textarea>
                    </div>
                    
                    <button type="submit" class="w-full bg-purple-700 text-white py-3 rounded-md hover:bg-purple-800 transition">Submit</button>
                </form>
                
                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                    <div class="flex items-center">
                        <img src="/api/placeholder/24/24" alt="Office" class="mr-2">
                        <span class="text-sm text-gray-600">Office Hours</span>
                    </div>
                    <div class="flex items-center">
                        <img src="/api/placeholder/24/24" alt="Phone" class="mr-2">
                        <span class="text-sm text-gray-600">+62 899-5555-3333</span>
                    </div>
                </div>
            </div>
            
            <div class="text-center text-sm text-gray-500 mt-8">
                Copyright @Labels-MM 2024 | Privacy Policy
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = "{{ session('success') }}";
            const errorMessage = "{{ session('error') }}";
            
            const shownSuccessAlert = localStorage.getItem('shownSuccessAlert');
            const shownErrorAlert = localStorage.getItem('shownErrorAlert');
            
            if (successMessage && successMessage !== shownSuccessAlert) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: successMessage
                });
                
                localStorage.setItem('shownSuccessAlert', successMessage);
                
                setTimeout(() => {
                    localStorage.removeItem('shownSuccessAlert');
                }, 10000);
            }
            
            if (errorMessage && errorMessage !== shownErrorAlert) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage
                });
                
                localStorage.setItem('shownErrorAlert', errorMessage);
                
                setTimeout(() => {
                    localStorage.removeItem('shownErrorAlert');
                }, 10000);
            }
        });
    </script>
</body>
</html>