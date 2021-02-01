Livewire.on('deleteTriggered', (id, name) => {
    const proceed = confirm(`Are you sure you want to delte ${name}`);

    if (proceed) {
        Livewire.emit('delete', id);
    }
});

window.addEventListener('user-delete', (event) => {
    alert(`${event.detail.userName} was deleted!`);
})

Livewire.on('triggerCreated', () => {
    $('#user-modal').modal('show');
});

window.addEventListener('user-saved', (event) => {
    $('#user-modal').modal('hide');
    alert(`User ${event.detail.userName} was ${event.detail.action}!`);
});


Livewire.on('dataFetched', (user) => {
    $('#user-modal').modal('show');
});

