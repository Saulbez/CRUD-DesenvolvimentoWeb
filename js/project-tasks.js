let stepForm = document.querySelector("div.form-wrapper");
let addStep = document.querySelector("button.new-step");

let tasksForm = document.querySelectorAll("div.tasks-form");
let addTask = document.querySelectorAll("button.new-task");
console.log (addTask);

collabBtn = document.querySelectorAll("button.collab-btn");
updateCollabForm = document.querySelectorAll("div.update-collab");
cancelBtnRespon = document.querySelectorAll("button.cancel-responsible");

taskDetailsBtn = document.querySelectorAll("button.task-details");
taskDetailsTable = document.querySelectorAll("div.task-details");
hideTaskDetailsBtn = document.querySelectorAll("button.hide-task-details");

editTaskBtn = document.querySelectorAll("button.edit-task");
updateTaskForm = document.querySelectorAll("div.task-update");
cancelBtnTaskUpdate = document.querySelectorAll("button.cancel-task-update");

addStep.addEventListener("click", function () {
    stepForm.classList.toggle("hidden");
    if(stepForm.classList.contains("hidden")) {
        addStep.textContent = "Nova etapa";
    } else {
        addStep.textContent = "Cancelar";
    }
});

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

document.querySelectorAll('.task-container').forEach(container => {
    container.addEventListener('dragover', (e) => {
        e.preventDefault(); // Permitir que o elemento seja solto
    });
    container.addEventListener('drop', drop);

    container.addEventListener('touchMove', (e) => {
        e.preventDefault(); // Permitir que o elemento seja solto
    });
    container.addEventListener('touchend', touchEnd);
});

function dragStart(e) {
    console.log('Dragging task with ID:', e.target.id);
    e.dataTransfer.setData('text/plain', e.target.id);
}

function dragOver(e) {
    e.preventDefault(); // Permitir que o elemento seja solto
}

function drop(e) {
    e.preventDefault();
    const taskId = e.dataTransfer.getData('text/plain');
    const task = document.getElementById(taskId);

    // Verifique se a tarefa foi encontrada antes de usá-la
    if (task) {
        const dropZone = e.target.closest('.task-container');

        if (dropZone) {
            dropZone.appendChild(task);

            const newStepId = dropZone.dataset.stepId; // Supondo que você tenha um data attribute com o novo ID da etapa
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
    const task = e.target;
    const taskId = task.id;

    // Adiciona um estilo para indicar que a tarefa está sendo "arrastada"
    task.classList.add('dragging');

    // Armazena a tarefa sendo arrastada
    task.dataset.touchId = taskId;
}

function touchMove(e) {
    const touch = e.touches[0];
    const taskId = e.target.dataset.touchId;
    const task = document.getElementById(taskId);

    // Atualiza a posição da tarefa arrastada
    if (task) {
        task.style.position = 'absolute';
        task.style.left = `${touch.pageX}px`;
        task.style.top = `${touch.pageY}px`;
    }
}

function touchEnd(e) {
    const taskId = e.target.dataset.touchId;
    const task = document.getElementById(taskId);
    const dropZone = document.elementFromPoint(e.changedTouches[0].clientX, e.changedTouches[0].clientY);

    if (dropZone && dropZone.classList.contains('task-container')) {
        dropZone.appendChild(task);

        const newStepId = dropZone.dataset.stepId; // Supondo que você tenha um data attribute com o novo ID da etapa
        console.log(taskId, newStepId);
        updateTaskInDatabase(taskId, newStepId);
    }

    // Limpa os estilos e dados
    task.classList.remove('dragging');
    task.style.position = '';
    task.style.left = '';
    task.style.top = '';
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