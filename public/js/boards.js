let currentTask = null;

document.addEventListener('DOMContentLoaded', () => {
    //alle taken ophalen die klikbaar zijn
    const tasks = document.querySelectorAll('.task');
    const lists = document.querySelectorAll('.list');

    //maakt de taken klikbaar
    tasks.forEach(task => {
        task.addEventListener('click', function() {
            openTaskModal(task);  //open model bij klikken van een taak
        });
    });

    //niet werkend
    lists.forEach(list => {
        list.addEventListener('dragover', e => {
            e.preventDefault();
            const draggingTask = document.querySelector('.dragging');
            list.appendChild(draggingTask);
        });
    });
});

//modal openen bij het klikken van een taak
function openTaskModal(task) {
    currentTask = task;
    const taskId = task.getAttribute('data-id');  //taak id ophalen
    const taskTitle = task.textContent.trim(); 

    //zet titel in modal
    document.getElementById('taskTitle').textContent = taskTitle;

    //controleer of er een omschrijving is, en toon deze.
    let taskDescription = task.getAttribute('data-description');
    console.log('Omschrijving uit data-description:', taskDescription);  

    if (!taskDescription) {
        console.log('Omschrijving niet gevonden, ophalen van server...');
        
        //omschrijving halen
        fetch(`/boards/${boardSlug}/tasks/${taskId}`)
            .then(response => response.json())
            .then(data => {
                if (data.task && data.task.Omschrijving) {
                    taskDescription = data.task.Omschrijving; //omschrijving updaten
                    task.setAttribute('data-description', taskDescription); 
                    document.getElementById('taskDescription').value = taskDescription;
                } else {
                    document.getElementById('taskDescription').value = ''; //laat omschrijving leeg, als er geen waarde is
                    console.log('Geen omschrijving beschikbaar voor deze taak.');
                }
            })
            .catch(error => {
                console.error('Fout bij het ophalen van omschrijving:', error);
            });
    } else {
        document.getElementById('taskDescription').value = taskDescription;  //zet omschrijving in modal en sla op
    }

    document.getElementById('taskModal').style.display = 'flex';
}



function closeTaskModal() {
    document.getElementById('taskModal').style.display = 'none';  // Sluit de modal
}

//sla omschrijving op in de database
function saveTaskDescription() {
    if (currentTask) {
        const description = document.getElementById('taskDescription').value.trim();

        if (description === "") {
            console.error("Omschrijving mag niet leeg zijn.");
            return;
        }

        //zet omschrijving in taak
        currentTask.setAttribute('data-description', description);
        const taskId = currentTask.getAttribute('data-id');  

        //opslaan
        fetch(`/boards/${boardSlug}/tasks/${taskId}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ description })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Beschrijving succesvol opgeslagen:', data);
            closeTaskModal();  //automatisch sluiten bij opslaan
        })
        .catch(error => {
            console.error('Er is een fout opgetreden:', error);
        });
    } else {
        console.error("Geen taak geselecteerd om op te slaan.");
    }
}

//taak toevoegen
function addTask(listId) {
    console.log("Lijst-ID die wordt doorgegeven:", listId); 

    const taskText = prompt('Voer de naam van de taak in:');
    if (taskText) {
        //lijsten worden opgehaald met de lijstid
        const list = document.getElementById("list-" + listId); 

        console.log("Lijst element:", list); 

        if (list) {
            const newTask = document.createElement('div');
            newTask.classList.add('task');
            newTask.setAttribute('draggable', 'true');
            newTask.setAttribute('data-id', Date.now()); 
            newTask.textContent = taskText;

            list.appendChild(newTask);  //toevoegen van taak aan een lijst

            //opslaan
            fetch(`/boards/${boardSlug}/lists/${listId}/tasks`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    title: taskText,
                    listId: listId
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Taak succesvol opgeslagen:', data);
            })
            .catch(error => {
                console.error('Er is een fout opgetreden:', error);
            });
        } else {
            console.error("Lijst niet gevonden met ID:", listId);  
        }
    }
}

//functie om een lijst toe te voegen
function addList() {
    const listName = prompt('Voer de naam van de nieuwe lijst in:');
    if (listName) {
        const board = document.querySelector('.board');
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
        deleteButton.onclick = () => newList.remove();  //verwijder de lijst

        const addTaskButton = document.createElement('button');
        addTaskButton.classList.add('add-task-btn');
        addTaskButton.textContent = '+ Voeg taak toe';
        addTaskButton.onclick = () => addTask(newList.id);  //voeg taak toe aan de lijst

        listHeader.appendChild(listTitle);
        listHeader.appendChild(deleteButton);

        newList.appendChild(listHeader);
        newList.appendChild(addTaskButton);

        board.appendChild(newList);  //voeg de nieuwe lijst toe aan het bord

        //sla nieuwe lijst op
        fetch(`/boards/${boardSlug}/lists`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ title: listName })
        })
        .then(response => response.json())
        .then(data => {
            console.log('Lijst succesvol toegevoegd:', data);
        })
        .catch(error => {
            console.error('Fout bij het toevoegen van lijst:', error);
        });
    }
}

//verwijder lijst
function deleteList(listId) {
    const list = document.getElementById(listId);
    if (list) {
        list.remove();
    } else {
        console.error("Lijst met ID " + listId + " niet gevonden.");
    }
}

//verwijder taak
function deleteTask(taskId) {
            //popup
    if (confirm("Weet je zeker dat je deze taak wilt verwijderen?")) {
        const taskElement = document.querySelector(`.task[data-id="${taskId}"]`);

        if (taskElement) {
            taskElement.remove();
        } else {
            console.error("Taak niet gevonden in de DOM.");
        }

        //verzoek verzenden
        fetch(`/boards/${boardSlug}/tasks/${taskId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('Taak succesvol verwijderd:', data);
        })
        .catch(error => {
            console.error('Er is een fout opgetreden:', error);
        });
    }


    
}
