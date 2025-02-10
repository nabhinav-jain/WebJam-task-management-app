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
  

    ?>


    <div class="ml-5 bg-transparent border-2 border-red-500 p-2 w-[3vw] flex items-center justify-center" onclick="openNewModal()">
        <button class="text-red-700 text-xl cursor-pointer" >
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>


<div id="newTaskModal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40 backdrop-blur-sm hidden">
    <div class="w-[400px] bg-white p-6 rounded-xl shadow-2xl">
        <h2 class="text-xl font-semibold text-red-600 mb-4">Create New Task</h2>
        <form method="POST" id="newTaskForm">
            <div class="mb-3">
                <label for="taskName" class="block text-red-600 font-medium">Task Name:</label>
                <input type="text" id="taskName" name="taskName" required class="w-full p-2 border rounded mt-1 outline-none focus:ring focus:ring-red-600">
            </div>
            <div class="mb-4">
                <label for="taskDueTime" class="block text-red-600 font-medium">Due Time:</label>
                <input type="datetime-local" id="taskDueTime" name="taskDueTime" required class="w-full p-2 border rounded mt-1 focus:ring outline-none focus:ring-red-600">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-red-600" onclick="closeNewModal()">Cancel</button>
                <button type="submit" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-red-600">Add Task</button>
            </div>
        </form>
    </div>
</div>



    <?php
        
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


<script src="includes/todo.js"></script>

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