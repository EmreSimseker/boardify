//elementen die nodig zijn
const daysGrid = document.getElementById('days-grid');
const currentMonth = document.getElementById('current-month');
const prevMonthBtn = document.getElementById('prev-month');
const nextMonthBtn = document.getElementById('next-month');
const modal = document.getElementById('modal');

//element voor cloe modal
const closeModalBtn = document.getElementById('close-modal');    
const closeModalX = document.getElementById('close-modal-x');    
//alles wat te maken heeft met de modal voor een tegel
const dateInput = document.getElementById('date');
const taskList = document.getElementById('task-list');
const deleteTaskBtn = document.getElementById('delete-task');
const taskIdInput = document.getElementById('task-id');

let currentDate = new Date();
let tasks = {}; // Taken geladen vanuit de backend


function renderCalendar(date, tasks) {
    const year = date.getFullYear();
    const month = date.getMonth();

    currentMonth.textContent = date.toLocaleDateString('nl-NL', {
        year: 'numeric',
        month: 'long'
    });

    //Eerste dag en aantal dagen in deze maand
    const firstDayOfMonth = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    //grid leegmaken
    daysGrid.innerHTML = '';

    //berekent aantal lege dagen voor een maand
    const emptyDays = (firstDayOfMonth + 6) % 7;
    for (let i = 0; i < emptyDays; i++) {
        const emptyDiv = document.createElement('div'); //maakt lege tegels 
        emptyDiv.classList.add('empty');
        daysGrid.appendChild(emptyDiv);
    }

    
    for (let day = 1; day <= daysInMonth; day++) {  //nieuwe dag element 
        const dayDiv = document.createElement('div');
        dayDiv.classList.add('day');
        dayDiv.textContent = day;

        const formattedDate = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;

        //kijkt er of er op deze dag taken zijn
        if (tasks[formattedDate] && tasks[formattedDate].length > 0) {
            //rood maken
            dayDiv.classList.add('has-task');

            dayDiv.addEventListener('click', () => {
                openModal(day, month, year, tasks[formattedDate]);
            });
        } else {
            dayDiv.addEventListener('click', () => {
                openModal(day, month, year, []);
            });
        }
        //voeg dag toe aan agenda
        daysGrid.appendChild(dayDiv);
    }
}


function openModal(day, month, year, tasksOfDay = []) {
    modal.classList.remove('hidden');

    // Reset formulier
    taskIdInput.value = '';
    document.getElementById('title').value = '';
    document.getElementById('description').value = '';
    dateInput.value = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
    document.querySelectorAll('input[name="Type"]').forEach(input => (input.checked = false));

    //toon taken
    taskList.innerHTML = tasksOfDay
        .map(task => `
            <li>
                ${task.Titel}: ${task.Omschrijving}
                <button type="button" onclick="editTask(${task.id}, '${task.Titel}', '${task.Omschrijving}', '${task.Datum}', '${task.Type}')">
                    Bewerken
                </button>
            </li>
        `)
        .join('');
}
//niet werkend
function editTask(id, title, description, date, type) {
    const form = document.getElementById('agenda-form');
    form.action = '/agenda/save';

    taskIdInput.value = id;
    document.getElementById('title').value = title;
    document.getElementById('description').value = description;
    document.getElementById('date').value = date;

    if (type) {
        const radio = document.querySelector(`input[name="Type"][value="${type}"]`);
        if (radio) {
            radio.checked = true;
        }
    }
    deleteTaskBtn.classList.remove('hidden');
}

//modal sluiten
closeModalBtn.addEventListener('click', () => {
    modal.classList.add('hidden');
});
closeModalX.addEventListener('click', () => {
    modal.classList.add('hidden');
});

//navigeren van de maanden
prevMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    renderCalendar(currentDate, tasks);
});
nextMonthBtn.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    renderCalendar(currentDate, tasks); //kalender opnieuw renderen
});

//niet werkend
deleteTaskBtn.addEventListener('click', () => {
    const taskId = taskIdInput.value;
    if (confirm('Weet je zeker dat je deze taak wilt verwijderen?')) {
        fetch(`/agenda/delete/${taskId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
        })
            .then(response => {
                if (response.ok) {
                    alert('Taak succesvol verwijderd!');
                    location.reload();
                } else {
                    return response.json().then(error => {
                        console.error(error.message);
                        alert('Er is iets misgegaan bij het verwijderen.');
                    });
                }
            })
            .catch(error => {
                console.error(error);
                alert('Er is een verbindingsfout opgetreden.');
            });
    }
});


document.addEventListener('DOMContentLoaded', () => {
    //taken inladen vanuit de server en kalender renderen
    tasks = JSON.parse(document.getElementById('tasks-data').textContent);
    renderCalendar(currentDate, tasks);
});
