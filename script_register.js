document.addEventListener('DOMContentLoaded', function() {
    const formRegister = document.getElementById('registration-form');
    
    if (formRegister) {
        formRegister.addEventListener('submit', function(event) {
            event.preventDefault();

            const formData = new FormData(formRegister);
            
            fetch(feedInstagramAjax.ajaxurl + '?action=feed_instagram_register', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                const messageElement = document.getElementById('registration-message');
                if (data.success) {
                    messageElement.textContent = 'Registro exitoso. Redirigiendo...';
                    setTimeout(() => {
                        window.location.href = feedInstagramAjax.loginUrl; 
                    }, 2000);
                } else {
                    messageElement.textContent = 'Error: ' + data.data;
                }
            })
            .catch(error => console.error('Error:', error));
        });
    }
});