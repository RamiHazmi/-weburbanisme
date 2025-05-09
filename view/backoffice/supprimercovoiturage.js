document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function() {
            const idTrajet = this.getAttribute('data-id');
            console.log("Attempting to delete covoiturage with ID: " + idTrajet);

            const modal = document.getElementById('confirmation-dialog');
            const loadingIndicator = document.getElementById('loading-indicator');

            if (modal) {
                modal.style.display = 'block';  // Show modal
            } else {
                console.error('Confirmation dialog not found!');
                return; // Exit early if modal is not found
            }

            const yesButton = document.getElementById('yes-delete');
            const noButton = document.getElementById('no-delete');

            yesButton.onclick = function() {
                if (loadingIndicator) {
                    loadingIndicator.style.display = 'block'; 
                }

                const requestData = { action: 'deleteCovoiturage', id_trajet: idTrajet };
                console.log('Request Data:', requestData);

                fetch('tablec.php', { 
                    method: 'POST', 
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(requestData)
                })
                .then(response => response.text())
                .then(text => {
                    console.log("Raw response text:", text);
                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed response:', data);
                        if (data.status === 'success') {
                            alert(data.message);
                            document.getElementById('row-' + idTrajet).remove();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    } catch (error) {
                        console.error('Error parsing JSON:', error);
                        alert('Failed to parse response. Please try again.');
                    } finally {
                        modal.style.display = 'none';
                        if (loadingIndicator) {
                            loadingIndicator.style.display = 'none';
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to delete the covoiturage. Please try again.');
                });
            };

            noButton.onclick = function() {
                modal.style.display = 'none';
            };
        });
    });
});