let currentTask = null;

document.addEventListener('DOMContentLoaded', () => {
    const tasks = document.querySelectorAll('.task');
    const lists = document.querySelectorAll('.list');

    tasks.forEach(task => {
        task.addEventListener('dragstart', () => {
            task.classList.add('dragging');
        });

        task.addEventListener('dragend', () => {
            task.classList.remove('dragging');
        });
    });

    lists.forEach(list => {
        list.addEventListener('dragover', e => {
            e.preventDefault();
            const draggingTask = document.querySelector('.dragging');
            list.appendChild(draggingTask);
        });
    });
});

function addTask(listId) {
    const taskText = prompt('Voer de naam van de taak in:');
    if (taskText) {
        const newTask = document.createElement('div');
        newTask.classList.add('task');
        newTask.setAttribute('draggable', 'true');
        newTask.setAttribute('onclick', 'openTaskModal(this)');
        newTask.textContent = taskText;

        newTask.addEventListener('dragstart', () => {
            newTask.classList.add('dragging');
        });

        newTask.addEventListener('dragend', () => {
            newTask.classList.remove('dragging');
        });

        const list = document.getElementById(listId);
        list.appendChild(newTask);
    }
}

function openTaskModal(task) {
    currentTask = task;
    document.getElementById('taskTitle').textContent = task.textContent;
    document.getElementById('taskDescription').value = task.getAttribute('data-description') || '';
    document.getElementById('taskModal').style.display = 'flex';
}

function closeTaskModal() {
    document.getElementById('taskModal').style.display = 'none';
}

function saveTaskDescription() {
    const description = document.getElementById('taskDescription').value;
    currentTask.setAttribute('data-description', description);
    closeTaskModal();
}

function addList() {
    const listName = prompt('Voer de naam van de nieuwe lijst in:');
    if (listName) {
        const trelloBoard = document.querySelector('.trello-board');
        const newList = document.createElement('div');
        newList.classList.add('list');
        newList.setAttribute('id', listName.toLowerCase().replace(/\s+/g, '-'));

        const listHeader = document.createElement('div');
        listHeader.classList.add('list-header');

        const listTitle = document.createElement('h3');
        listTitle.textContent = listName;

        const deleteButton = document.createElement('button');
        deleteButton.classList.add('delete-list-btn');
        deleteButton.textContent = '×';
        deleteButton.onclick = () => newList.remove();

        const addTaskButton = document.createElement('button');
        addTaskButton.classList.add('add-task-btn');
        addTaskButton.textContent = '+ Voeg taak toe';
        addTaskButton.onclick = () => addTask(newList.id);

        listHeader.appendChild(listTitle);
        listHeader.appendChild(deleteButton);
        newList.appendChild(listHeader);
        newList.appendChild(addTaskButton);

        trelloBoard.appendChild(newList);
    }
}

function deleteList(listId) {
    document.getElementById(listId).remove();
}
