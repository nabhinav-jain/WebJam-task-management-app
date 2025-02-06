<?php
include('header.php');
?>
<div class="h-screen flex items-center justify-center bg-white">
    <!-- heading -->
<div class="absolute top-8 text-center w-full">
        <h1 class="text-4xl font-bold text-red-600">Discord WebJam</h1>
    </div>


    <form class="p-8 rounded-lg shadow-lg w-full max-w-md" id="register-form">
    <div class="mb-4">
        <label class="block text-red-600 mb-1">Username</label>
        <input type="text" name="username" class="w-full p-3 border border-gray-300 rounded-lg text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" required>
    </div>
    <div class="mb-4 relative">
        <label class="block text-red-600 mb-1">Password</label>
        <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" required>
        <span id="eye-icon" class="absolute right-3 top-3 cursor-pointer text-gray-500 mt-[30px]">
            <i class="bi bi-eye"></i>
        </span>
    </div>
    <div class="mb-4 relative">
        <label class="block text-red-600 mb-1">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password" class="w-full p-3 border border-gray-300 rounded-lg text-red-600 focus:outline-none focus:ring-2 focus:ring-red-400" required>
        <span id="eye-icon-confirm" class="absolute right-3 top-3 cursor-pointer text-gray-500 mt-[30px]" >
            <i class="bi bi-eye"></i>
        </span>
    </div>
    <button type="submit" class="w-full p-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">Register</button>

    <div class="text-center mt-5">
        <a href="index.php" class="w-full p-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition inline-block">Go to Login</a>
    </div>
</form>


</div>

<script>
const regForm = document.getElementById('register-form');
regForm.addEventListener('submit', function(event) {
  event.preventDefault(); 
  const formData = new FormData(this); 
  
  fetch("api/register.php", {
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
            text: "Registered successfully",
            duration: 3000,
            backgroundColor: "green",
        }).showToast();
    }
})
.catch(error => {
    console.error("Error:", error);
});


});


    const eyeIcon = document.getElementById('eye-icon');
    const eyeIconConfirm = document.getElementById('eye-icon-confirm');
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');

    eyeIcon.addEventListener('click', () => {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            passwordInput.type = 'password';
            eyeIcon.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });

    eyeIconConfirm.addEventListener('click', () => {
        if (confirmPasswordInput.type === 'password') {
            confirmPasswordInput.type = 'text';
            eyeIconConfirm.innerHTML = '<i class="bi bi-eye-slash"></i>';
        } else {
            confirmPasswordInput.type = 'password';
            eyeIconConfirm.innerHTML = '<i class="bi bi-eye"></i>';
        }
    });


</script>
</body>
</html>