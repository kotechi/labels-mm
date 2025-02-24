<!DOCTYPE html>
<html lang="en" class="antialiased">
<head>
    <!-- ...existing code... -->
</head>
<body class="bg-gray-100 text-gray-900 tracking-wider leading-normal">
    <div class="container w-full md:w-4/5 xl:w-3/5 mx-auto px-2">
        <h1 class="flex items-center font-sans font-bold break-normal text-indigo-500 px-2 py-8 text-xl md:text-2xl">
            Create New Header
        </h1>
        <div class="p-8 mt-6 lg:mt-0 rounded shadow bg-white">
            <form action="{{ route('headers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="tittle" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                    <input type="text" name="tittle" id="tittle" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                    <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                    <input type="file" name="image" id="image" accept="image/*" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
