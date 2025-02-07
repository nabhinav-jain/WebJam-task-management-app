<?php
include('header.php');

if(!$_SESSION['isLogin']){
    header("Location: index.php");
    exit;
}

include("includes/headbar.php");
include("includes/sidebar.php");
// header.php included anywhere needs body html closing tags
$user_id=$_SESSION['user_id'];
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $baseurl."api/getTodo.php?user_id=$user_id"); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$curlResult = curl_exec($ch);

if ($curlResult === false) {
    echo 'Curl error: ' . curl_error($ch);
} else {
    $responseData = json_decode($curlResult, true);
    
    echo '<script>';
    echo 'console.log(' . json_encode($responseData) . ');';
    echo '</script>';
    $todoArray=$responseData;
}
curl_close($ch);



?>



<div class="main-content-container">
    <?php
if (!isset($_GET['code']) || $_GET['code']=='todo') {
    if (isset($todoArray['status']) && $todoArray['status'] === 'success' && isset($todoArray['todos'])) {
  
        
echo '<div class="p-4">';
        echo '<table class="w-full text-white bg-gray-800 border border-gray-700 rounded-lg">';
        echo '<thead>';
        echo '<tr class="bg-red-600 text-white text-left">';
        echo '<th class="px-4 py-2">Todo</th>';
        echo '<th class="px-4 py-2">Created At</th>';
        echo '<th class="px-4 py-2">Due Time</th>';
        echo '<th class="px-4 py-2">Current Time</th>';
        echo '<th class="px-4 py-2">Status</th>';
        echo '<th class="px-4 py-2 text-center">Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($todoArray['todos'] as $todo) {
            echo '<tr class="border-b border-gray-700">';
            echo '<td class="px-4 py-2">' . htmlspecialchars($todo['todo']) . '</td>';
            echo '<td class="px-4 py-2">' . htmlspecialchars($todo['created_at']) . '</td>';
            echo '<td class="px-4 py-2">' . htmlspecialchars($todo['due_time']) . '</td>';
            echo '<td class="px-4 py-2">' . date('Y-m-d H:i') . '</td>'; 
            echo '<td class="px-4 py-2 text-center">';
            echo '<input type="checkbox" class="w-5 h-5 cursor-pointer checboxToDo" 
            onclick="showModal(' . htmlspecialchars($todo['id']) . ')" 
            data-id="' . htmlspecialchars($todo['id']) . '" 
            ' . ($todo['status'] == 1 ? 'checked disabled' : '') . '>';
    
            echo '</td>';

            echo '<td class="px-4 py-2 text-center">';
            echo '<button onclick="showDeleteModal('. htmlspecialchars($todo['id']).')" class="text-red-500" > ';
            echo '<i class="bi bi-trash-fill text-xl"></i>';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }

        ?>
        <div id="confirmModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="w-[300px] bg-red-600 text-white p-4 rounded-lg shadow-lg">
        <p>Are you sure you want to check this task as done?</p>
        <form method="POST" id="checkTodoForm" >
            <input type="hidden" name="modalTodoId" id="modalTodoId">
            <div class="mt-4 flex justify-between">
                <button type="submit" class="bg-white text-red-600 px-4 py-2 rounded">Yes</button>
                <button type="button" class="bg-gray-700 px-4 py-2 rounded" onclick="hideModal()">No</button>
            </div>
        </form>
    </div>
</div>

<div id="confirmDeleteModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
    <div class="w-[300px] bg-red-600 text-white p-4 rounded-lg shadow-lg">
        <p>Are you sure you want to delete this Task?</p>
        <form method="POST" id="deleteTodoForm" >
            <input type="hidden" name="deleteTodoModal" id="deleteTodoModal">
            <div class="mt-4 flex justify-between">
                <button type="submit" class="bg-white text-red-600 px-4 py-2 rounded">Yes</button>
                <button type="button" class="bg-gray-700 px-4 py-2 rounded" onclick="hideModal()">No</button>
            </div>
        </form>
    </div>
</div>


<script>

function showDeleteModal(key){
    let confirmDeleteModal = document.getElementById('confirmDeleteModal');
    confirmDeleteModal.classList.remove('hidden');
    let deleteTodoModal = document.getElementById('deleteTodoModal'); 
    deleteTodoModal.value = key;
}




    function showModal(key){
        const confirmModal= document.getElementById('confirmModal');
        confirmModal.classList.remove('hidden');

        checkToDoId= document.getElementById('modalTodoId');
        checkToDoId.value=key;

    }
    function hideModal() {
    const confirmModal = document.getElementById('confirmModal');
    confirmModal.classList.add('hidden');

    let confirmDeleteModal= document.getElementById('confirmDeleteModal');
    confirmDeleteModal.classList.add('hidden');

    let todoId = document.getElementById('modalTodoId').value;
    const checboxToDo = document.querySelector(`.checboxToDo[data-id='${todoId}']`);

    if (checboxToDo) { 
        checboxToDo.checked = false;
    }
}

document.getElementById('deleteTodoForm').addEventListener('submit',function(event){
     event.preventDefault();

     const formData=new FormData(this);
     fetch('api/deleteTodo.php',{
        method:'post',
        body:formData
     }).then(response=>response.json()).then((data)=>{

        if(data.status=='success'){
            Toastify({
                text: data.message,
                backgroundColor: "green",
                duration: 3000
               
            }).showToast();
            setTimeout(()=>  window.location.reload(),500)
        }else{
            Toastify({
                text: data.message,
                backgroundColor: "red",
                duration: 3000
               
            }).showToast();
        }
     }).catch(err=>{
        Toastify({
                text: "Internal server error",
                backgroundColor: "red",
                duration: 3000
               
            }).showToast();
     }); 

})



document.getElementById('checkTodoForm').addEventListener('submit', function (e) {
    e.preventDefault(); 
    console.log("Form submission intercepted");

    const formData = new FormData(this);
    console.log("Form data created:", formData);

    fetch('api/checkTodo.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log("Response received from the server:", response);
        return response.json(); 
    })
    .then(data => {
        console.log("Parsed JSON data:", data);

        if (data.status === 'success') {
            console.log("Status is success, showing success toast");
            Toastify({
                text: data.message,
                backgroundColor: "green",
                duration: 3000
               
            }).showToast();
            setTimeout(()=>  window.location.reload(),500)
          
        } else {
            console.log("Status is not success, showing failure toast");
            Toastify({
                text: data.message,
                backgroundColor: "red",
                duration: 3000
            }).showToast();
        }
        hideModal();
        console.log("Modal hidden after form submission");
    })
    .catch(error => {
        console.log("Error occurred during fetch:", error);
        Toastify({
            text: "An error occurred. Please try again.",
            backgroundColor: "red",
            duration: 3000
        }).showToast();
        hideModal();
        console.log("Modal hidden due to error");
    });
});


</script>

        <?php
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p class="text-white text-center">No todos found!</p>';
    }
}
else if (isset($_GET['code'])) {

    }
    ?>
</div>