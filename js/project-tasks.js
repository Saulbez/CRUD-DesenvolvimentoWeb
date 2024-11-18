let stepForm = document.querySelector("div.form-wrapper");
let addStep = document.querySelector("button.new-step");

let tasksForm = document.querySelectorAll("div.tasks-form");
let addTask = document.querySelectorAll("button.new-task");
console.log (addTask);

const collabBtn = document.querySelectorAll("button.collab-btn");
const updateCollabForm = document.querySelectorAll("div.update-collab");
const cancelBtnRespon = document.querySelectorAll("button.cancel-responsible");

const taskDetailsBtn = document.querySelectorAll("button.task-details");
const taskDetailsTable = document.querySelectorAll("div.task-details");
const hideTaskDetailsBtn = document.querySelectorAll("button.hide-task-details");

const editTaskBtn = document.querySelectorAll("button.edit-task");
const updateTaskForm = document.querySelectorAll("div.task-update");
const cancelBtnTaskUpdate = document.querySelectorAll("button.cancel-task-update");

const editStepBtn = document.querySelectorAll("button.edit-step");
const editStepForm = document.querySelectorAll("div.update-step");
const cancelStepUpdateBtn = document.querySelectorAll("button.cancel-step-update");

const deleteStepBtnFirst = document.querySelectorAll("button.delete-step-first");
const deleteStepConfirmation = document.querySelectorAll("div.delete-step-confirmation");
const cancelDeleteStep = document.querySelectorAll("button.cancel-delete-step");

for (let i = 0; i < deleteStepBtnFirst.length; i++) {
    deleteStepBtnFirst[i].addEventListener("click", function () {
        deleteStepConfirmation[i].classList.remove("hidden");
    });
}

for (let i = 0; i < cancelDeleteStep.length; i++) {
    cancelDeleteStep[i].addEventListener("click", function () {
        deleteStepConfirmation[i].classList.add("hidden");
    });
}


addStep.addEventListener("click", function () {
    stepForm.classList.toggle("hidden");
    if(stepForm.classList.contains("hidden")) {
        addStep.textContent = "Nova etapa";
    } else {
        addStep.textContent = "Cancelar";
    }
});

for (let i = 0; i < editStepBtn.length; i++) {
    editStepBtn[i].addEventListener("click", function () {
        editStepForm[i].classList.remove("hidden");
    });
}

for (let i = 0; i < cancelStepUpdateBtn.length; i++) {
    cancelStepUpdateBtn[i].addEventListener("click", function () {
        editStepForm[i].classList.add("hidden");
    });
}

for (let i = 0; i < addTask.length; i++) {
    addTask[i].addEventListener("click", function () {
        tasksForm[i].classList.toggle("hidden");

        if (tasksForm[i].classList.contains("hidden")) {
            addTask[i].textContent = "Nova tarefa";
        } else {
            addTask[i].textContent = "Cancelar";
        }
    });
}

for (let i = 0; i < collabBtn.length; i++) {
    if(collabBtn) {
        collabBtn[i].addEventListener("click", function () {
            updateCollabForm[i].classList.remove("hidden");
        });
    }
}

for (let i = 0; i < cancelBtnRespon.length; i++) {
    if(cancelBtnRespon) {
        cancelBtnRespon[i].addEventListener("click", function () {
            updateCollabForm[i].classList.add("hidden");
        });
    }
}

for (let i = 0; i < taskDetailsBtn.length; i++) {
    if(taskDetailsBtn) {
        taskDetailsBtn[i].addEventListener("click", function () {
            taskDetailsTable[i].classList.remove("hidden");
        });
    }
}

for (let i = 0; i < hideTaskDetailsBtn.length; i++) {
    if(hideTaskDetailsBtn) {
        hideTaskDetailsBtn[i].addEventListener("click", function () {
            taskDetailsTable[i].classList.add("hidden");
        });
    }
}

for (let i = 0; i < editTaskBtn.length; i++) {
    if(editTaskBtn) {
        editTaskBtn[i].addEventListener("click", function () {
            updateTaskForm[i].classList.remove("hidden");
        });
    }
}

for (let i = 0; i < cancelBtnTaskUpdate.length; i++) {
    if(cancelBtnTaskUpdate) {
        cancelBtnTaskUpdate[i].addEventListener("click", function () {
            updateTaskForm[i].classList.add("hidden");
        });
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.del-collaborator-btn');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {

            event.preventDefault();

            const confirmation = confirm("Você tem certeza que deseja excluir este projeto? Esta ação não pode ser desfeita.");

            if (confirmation) {

                window.location.href = this.querySelector('.delete-link').href;
            }

        });
    });
});

const tasks = document.querySelectorAll('.task');
const steps = document.querySelectorAll('.table-wrapper');

tasks.forEach(task => {
    task.addEventListener('dragstart', dragStart);
    task.addEventListener('touchstart', touchStart);
});

steps.forEach(step => {
    step.addEventListener('dragover', dragOver);
    step.addEventListener('drop', drop);
    step.addEventListener('touchmove', touchMove);
    step.addEventListener('touchend', touchEnd);
});

function dragStart(e) {
    console.log('Dragging task with ID:', e.target.id);
    e.dataTransfer.setData('text/plain', e.target.id);
}

function dragOver(e) {
    e.preventDefault();
}

function drop(e) {
    e.preventDefault();
    const taskId = e.dataTransfer.getData('text/plain');
    const task = document.getElementById(taskId);

    if (task) {
        const dropZone = e.target.closest('.task-container');

        if (dropZone) {
            dropZone.appendChild(task);

            const newStepId = dropZone.dataset.stepId;
            console.log(taskId, newStepId);
            updateTaskInDatabase(taskId, newStepId);
        } else {
            console.error('Nenhum contêiner pai encontrado para adicionar a tarefa.');
        }
    } else {
        console.error('Tarefa não encontrada:', taskId);
    }
}

function touchStart(e) {
    const task = e.target.closest('.task');
    if (task) {
        console.log('Iniciando toque na tarefa:', task.id);
    }
    const taskId = task.id;
    startX = e.touches[0].pageX;
    startY = e.touches[0].pageY;

    dragTimeout = setTimeout(() => {
        task.classList.add('dragging');
        isDragging = true;
    }, 300);

    isMovingHorizontal = false;
}

function touchMove(e) {
    if (!isDragging) return;

    e.preventDefault();
    const touch = e.touches[0];
    const task = document.querySelector('.task.dragging');

    if (task) {

        task.style.position = 'absolute';
        task.style.left = `${touch.pageX - (task.offsetWidth / 2)}px`;
        task.style.top = `${touch.pageY - (task.offsetHeight / 2)}px`;
        
        console.log('Arrastando tarefa:', task.id);

    }
}

function touchEnd(e) {
    clearTimeout(dragTimeout);

    if (!isDragging) return;

    const task = document.querySelector('.task.dragging');
    const dropZone = document.elementFromPoint(e.changedTouches[0].clientX, e.changedTouches[0].clientY);

    console.log('Zona de soltar detectada:', dropZone);

    const validDropZone = dropZone.closest('.task-container');

    if (validDropZone) {
        validDropZone.appendChild(task);

        const newStepId = validDropZone.dataset.stepId;
        console.log('Tarefa movida:', task.id, 'para a nova etapa:', newStepId);
        updateTaskInDatabase(task.id, newStepId);
    } else {
        console.error('Zona de soltar inválida ou não encontrada.');
    }

    // Limpa os estilos e dados
    if (task) {
        task.classList.remove('dragging');
        task.style.position = '';
        task.style.left = '';
        task.style.top = '';
    }

    isDragging = false;
}

function updateTaskInDatabase(taskId, newStepId) {
    console.log('Enviando dados para o servidor...');
    fetch('controllers/update-task-step.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            'task-id': taskId,
            'newStepId': newStepId
        })
    })
    .then(response => {
        console.log('Resposta recebida do servidor:', response);
        return response.json();
    })
    .then(data => {
        console.log('Dados recebidos:', data);
        if (data.success) {
            console.log('Tarefa atualizada com sucesso!');
        } else {
            console.error('Erro ao atualizar a tarefa:', data.message);
        }
    })
    .catch(error => {
        console.error('Erro ao enviar a solicitação:', error);
    });
}