<?php
include('header.php');

?>
    <!-- form code for login -->
    <div class="h-screen flex items-center justify-center bg-white">
    <div class="absolute top-8 text-center w-full">
        <h1 class="text-4xl font-bold text-red-600">Discord WebJam</h1>
    </div>
    <form class="p-8 rounded-lg shadow-lg w-full max-w-md" id="logForm">
        <div class="mb-4">
            <label class="block text-red-600 mb-1">Username</label>
            <input type="text" name="username" class="w-full p-3 border border-gray-300 rounded-lg text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>
        <div class="mb-4">
            <label class="block text-red-600 mb-1">Password</label>
            <input type="password" name="password" class="w-full p-3 border border-gray-300 rounded-lg text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
        </div>
        <button class="w-full p-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Login</button>
        <div class="mt-4 text-center">
            <span class="text-gray-600">New User?</span>
            <a href="register.php" class="text-red-600 hover:underline">Register here</a>
        </div>
    </form>
</div>


<script>

const logForm = document.getElementById('logForm');
logForm.addEventListener('submit', function(event) {
  event.preventDefault(); 
  const formData = new FormData(this); 
  
  fetch("api/login.php", {
    method: 'POST',
    body: formData
})
.then(response => response.json())
.then((data) => {
    if (data.status == 'failed') {
        Toastify({
            text: data.message,
            duration: 5000,
            backgroundColor: "red",
        }).showToast();
    } else {
        Toastify({
            text: "Login successfully",
            duration: 3000,
            backgroundColor: "green",
        }).showToast();
        window.location.href="dashboard.php";
    }
})
.catch(error => {
    console.error("Error:", error);
});


});
</script>


</body>
</html>