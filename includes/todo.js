
function openNewModal() {
    document.getElementById('newTaskModal').classList.remove('hidden');
}

function closeNewModal() {
    document.getElementById('newTaskModal').classList.add('hidden');
}



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


document.getElementById('newTaskForm').addEventListener('submit',function(event){
 event.preventDefault();

 const formData=new FormData(this);
 fetch('api/createTodo.php',{
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

