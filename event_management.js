

document.addEventListener('DOMContentLoaded', () => {

    const eventModal = document.getElementById('eventModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalSubmitBtn = document.getElementById('modalSubmitBtn');
    const eventAction = document.getElementById('eventAction');
    const eventID = document.getElementById('eventID');
    

    function resetEventModalForm() {

        document.getElementById('event_name').value = '';
        document.getElementById('event_date').value = '';
        document.getElementById('num_tickets').value = 100;
    }


    const openCreateEventModal = document.getElementById('openCreateEventModal');
    if (openCreateEventModal) {
        openCreateEventModal.addEventListener('click', function() {
            resetEventModalForm();
            modalTitle.textContent = 'Create New Event';
            modalSubmitBtn.textContent = 'Create Event';
            modalSubmitBtn.style.backgroundColor = '#4CAF50'; // Green for create
            eventAction.value = 'create';
            eventID.value = '';
            eventModal.style.display = 'flex';
        });
    }


    document.querySelectorAll('.edit-event-btn').forEach(button => {
        button.addEventListener('click', function() {
            const eventId = this.getAttribute('data-event-id');
            

            document.getElementById('event_name').value = this.getAttribute('data-name');
            document.getElementById('event_date').value = this.getAttribute('data-date');
            document.getElementById('num_tickets').value = this.getAttribute('data-tickets');
            

            modalTitle.textContent = 'Edit Event (ID: ' + eventId + ')';
            modalSubmitBtn.textContent = 'Save Changes';
            modalSubmitBtn.style.backgroundColor = '#007bff'; // Blue for edit/save
            eventAction.value = 'edit';
            eventID.value = eventId;

            eventModal.style.display = 'flex';
        });
    });
});