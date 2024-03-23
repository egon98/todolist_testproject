document.addEventListener('DOMContentLoaded', function () {
    const statusSelects = document.querySelectorAll('.status-select');

    statusSelects.forEach(select => {
        select.addEventListener('change', function () {
            const todoId = this.dataset.todoId;
            const status = this.value;

            fetch('/todo/update-status', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    todo_id: todoId,
                    status: status
                })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Feladat állapota frissítve!');
                    } else {
                        throw new Error('Failed to update status');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
});



