<?php
include('header.php');

?>
    <!-- form code for login -->
    <div class="h-screen flex items-center justify-center bg-white">
    <div class="absolute top-8 text-center w-full">
        <h1 class="text-4xl font-bold text-red-600">Discord WebJam</h1>
    </div>
    <form class="p-8 rounded-lg shadow-lg w-full max-w-md" method="POST" action="api/login.php">
        <div class="mb-4">
            <label class="block text-red-600 mb-1">Username</label>
            <input type="text" class="w-full p-3 border border-gray-300 rounded-lg text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>
        <div class="mb-4">
            <label class="block text-red-600 mb-1">Password</label>
            <input type="password" class="w-full p-3 border border-gray-300 rounded-lg text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>
        <button class="w-full p-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Login</button>
        <div class="mt-4 text-center">
            <span class="text-gray-600">New User?</span>
            <a href="register.php" class="text-red-600 hover:underline">Register here</a>
        </div>
    </form>
</div>


</body>
</html>