<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Labels-MM</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('storage/images/icon/logo_label.png') }}" alt="Logo">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<style>
    :root {
        scroll-behavior: smooth;
    }
    .bg-labels {
        background-color: #9A1573;
    }
    .text-color-labels {
        color: #9A1573;
    }
    .btn-labels {
        background-color: #9A1573;
    }
    .btn-labels:hover {
        background-color: #7d1160;
    }
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>
<body class=" bg-purple-50">
    <nav class="bg-white py-2  shadow-md fixed w-full z-10">
        <div class="container mx-auto flex justify-between items-center px-4">
            <div class="flex items-center">
                <img src="{{ asset('storage/images/icon/logo.jpg') }}" alt="Logo" class="mr-2 w-10 h-10">
                <span class="font-bold text-lg text-color-labels">Labels - MM</span>
            </div>
            <div class="hidden md:flex space-x-6">
                <a href="#home" class="text-gray-800  hover:text-color-labels">HOME</a>
                <a href="#about" class="text-gray-800 hover:text-color-labels">ABOUT</a>
                <a href="#gallery" class="text-gray-800 hover:text-color-labels">GALLERY</a>
                <a href="#contact" class="text-gray-800  hover:text-color-labels">CONTACT</a>
            </div>
        </div>
    </nav>
    <div id="home" class="bg-gradient-to-tr from-purple-50 to-fuchsia-400 py-24 pb-12 relative overflow-hidden">
        <div class="container mx-auto px-7" >
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 p-4 mb-8 md:mb-0">
                    <h2 class="text-color-labels font-bold text-xl mb-2">HELLO, SELAMAT DATANG</h2>
                    <h1 class=" font-bold text-3xl mb-4">{{$headers->tittle}}</h1>
                    <p class="text-gray-700 mb-6">
                        {{$headers->description}}
                    </p>
                    <a href="#about" class="btn-labels text-white px-6 py-2 rounded-lg transition">SELENGKAPNYA</a>
                </div>
                <div class="md:w-1/2 flex justify-center py-20">
                    <img src="{{ asset('storage/' . $headers->image) }}" alt="Fashion Display" class="rounded-lg shadow-lg w-80 h-90">
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 right-0">
            <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M150 0C150 82.8427 82.8427 150 0 150V0H150Z" fill="#9A1573" fill-opacity="0.1"/>
            </svg>
        </div>
    </div>

    <div id="about" class="py-16 px-24 bg-gradient-to-br from-purple-50 to-fuchsia-400 relative">

        <div class="container mx-auto px-4">
            <h2 data-aos="zoom-in-down"  class="text-center text-color-labels font-bold text-2xl mb-20">About Us</h2>
            
            <div class="flex flex-col md:flex-row items-center md:items-start">
                <div class="md:w-1/3 flex justify-center mb-8 md:mb-0 md:order-1" data-aos="zoom-in-down">
                    <img src="{{ asset('storage/' . $abouts->image) }}" alt="Model" class="rounded-tl-[75px] rounded-br-[75px] shadow-lg w-[17rem] h-[20rem] object-cover">
                </div>
                <div data-aos="zoom-in-down" data-aos-delay="500"  class="md:w-2/3 pr-0 md:pr-8 md:order-0">
                    <h3 class="text-color-labels font-semibold text-xl mb-4">{{$abouts->tittle}}</h3>
                    
                    <div class="mb-16">
                        <div class="flex items-start mb-2 pr-24 ">
                            <div>
                                <p class="text-gray-600 text-md">{{$abouts->deskripsi}}</p>
                            </div>
                        </div>
                    </div>

                    <a data-aos="zoom-in-down" data-aos-delay="400" href="#contact" class="btn-labels text-white px-6 py-2 rounded-lg transition mt-4">Hubungi kami</a>
                </div>

            </div>
        </div>
        
        <div class="absolute bottom-0 right-0 ">
            <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M0 150C0 67.1573 67.1573 0 150 0V150H0Z" fill="#9A1573" fill-opacity="0.1"/>
            </svg>
        </div>
    </div>

    <div id="gallery" class="py-16 bg-white relative">
        <div class="container mx-auto px-4">
            <h2 data-aos="zoom-in-down" class="text-center text-color-labels font-bold text-2xl mb-2">Gallery</h2>
            <p data-aos="zoom-in-down" data-aos-delay="400" class="text-center text-gray-600 mb-10">Some of our products</p>
            
            <div class="relative">
                <div class="flex overflow-x-auto scrollbar-hide pb-4 space-x-9">
                    @foreach($products as $product)
                    <div data-aos="zoom-in-down" data-aos-delay="550" class="bg-white p-4 rounded-lg shadow-lg flex-shrink-0 w-64 border-2 border-[#9A1573]/50">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->nama_produk }}" class="w-full h-64 object-cover rounded-md mb-2">
                        <h4 class="font-medium text-center text-sm">{{$product->nama_produk}}</h4>
                        <p class="text-center text-color-labels font-semibold text-sm">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="absolute top-0 left-0">
            <svg width="150" height="150" viewBox="0 0 150 150" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M150 0C150 82.8427 82.8427 150 0 150V0H150Z" fill="#9A1573" fill-opacity="0.1"/>
            </svg>
        </div>
    </div>

    <div id="contact" class="px-20 pt-9 bg-pink-100">
        <div class="container mx-auto px-4">
            <h2 data-aos="zoom-in-down"  class="text-center text-color-labels font-bold text-2xl mb-10">Contact</h2>
            
            
            <div class="flex flex-col md:flex-row gap-6">
                <div class="md:w-1/2">
                    <div class="bg-white rounded-lg shadow-md p-10" data-aos="zoom-in-down" data-aos-delay="450">
                        <h3 class="font-semibold mb-4 text-center">Form Contact</h3>
                        
                        <form id="contactForm" action="{{ route('contact.lp.store')}}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" id="nama" placeholder="Enter your name" class="p-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-pink-500" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="email" id="email" placeholder="Enter your email" class="p-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-pink-500" required>
                            </div>
                            
                            <div class="mb-6">
                                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message <span class="text-red-500">*</span></label>
                                <textarea name="message" id="message" placeholder="Enter your message" rows="4" class="p-3 block w-full border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-pink-500" required></textarea>
                            </div>
                            
                            <button type="submit" class="w-full btn-labels text-white py-3 rounded-md transition">Submit</button>
                        </form>
                        
                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-color-labels" viewBox="0,0,256,256">
                                    <g fill="#dd1ccf" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><g transform="scale(5.12,5.12)"><path d="M16,3c-7.17,0 -13,5.83 -13,13v18c0,7.17 5.83,13 13,13h18c7.17,0 13,-5.83 13,-13v-18c0,-7.17 -5.83,-13 -13,-13zM37,11c1.1,0 2,0.9 2,2c0,1.1 -0.9,2 -2,2c-1.1,0 -2,-0.9 -2,-2c0,-1.1 0.9,-2 2,-2zM25,14c6.07,0 11,4.93 11,11c0,6.07 -4.93,11 -11,11c-6.07,0 -11,-4.93 -11,-11c0,-6.07 4.93,-11 11,-11zM25,16c-4.96,0 -9,4.04 -9,9c0,4.96 4.04,9 9,9c4.96,0 9,-4.04 9,-9c0,-4.96 -4.04,-9 -9,-9z"></path></g></g>
                                </svg>
                                <span class="text-sm text-gray-600">@labels_mm</span>
                            </div>
                            <a href="wa.me/+62-895-6671-9076" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-color-labels" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                </svg>
                                <span class="text-sm text-gray-600">+62 895 6671 9076</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="md:w-1/2">
                    <div class="bg-white rounded-lg shadow-md h-full" data-aos="zoom-in-down" data-aos-delay="450">
                        <iframe 
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3963.4894669995065!2d106.75623947441504!3d-6.585915564379278!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5457e0e3bcf%3A0x58481d58737539c0!2sSMK%20Negeri%201%20Ciomas!5e0!3m2!1sid!2sid!4v1745755529800!5m2!1sid!2sid" 
                            width="100%" 
                            height="100%" 
                            style="border:0; min-height: 400px;" 
                            allowfullscreen="" 
                            loading="lazy" 
                            referrerpolicy="no-referrer-when-downgrade"
                            class="rounded-lg">
                        </iframe>
                    </div>
                </div>
            </div>
            
            <div class="text-center text-sm text-gray-500 mt-8">
                Copyright © Labels-MM 2024 | Privacy Policy
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Smooth scrolling for navbar links
            document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        // Account for fixed navbar height
                        const navbarHeight = document.querySelector('nav').offsetHeight;
                        const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                        
                        window.scrollTo({
                            top: targetPosition,
                            behavior: 'smooth'
                        });
                    }
                });
            });
            
            // SweetAlert notifications
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