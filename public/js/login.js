// ... código existente ...

// Función para verificar el login
function verificarLogin() {
    const documento = document.getElementById("username").value; // Captura el documento
    const password = document.getElementById("password").value; // Captura la contraseña
    const mensaje = document.getElementById("message");
    let intentosRestantes = 3; // Inicializa el contador de intentos

    // Verifica que los campos no estén vacíos
    if (!documento || !password) {
        mensaje.style.color = "red";
        mensaje.textContent = "Por favor, completa todos los campos.";
        return;
    }

    fetch("../../models/php/login.php", { // Ajustar la ruta
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded"
        },
        body: new URLSearchParams({
            username: documento, // Envía el documento
            password: password // Envía la contraseña
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            mensaje.style.color = "blue";
            mensaje.textContent = data.message;
            setTimeout(() => {
                window.location.href = "../htmlyjs/productos.html"; // Redirigir a productos.html
            }, 1000);
        } else {
            intentosRestantes--;
            mensaje.style.color = "red";
            mensaje.textContent = data.message;
            
            if (intentosRestantes === 0) {
                mensaje.textContent = "Cuenta bloqueada. Intenta más tarde";
                document.getElementById("username").disabled = true;
                document.getElementById("password").disabled = true;
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        mensaje.style.color = "red";
        mensaje.textContent = "Error de conexión. Por favor, intenta más tarde.";
    });
}

// Agregar el código para manejar los botones de cambio entre paneles
document.addEventListener('DOMContentLoaded', function() {
    const signUpButton = document.getElementById('signUp');
    const signInButton = document.getElementById('signIn');
    const container = document.getElementById('container');

    signUpButton.addEventListener('click', () => {
        container.classList.add("right-panel-active");
    });

    signInButton.addEventListener('click', () => {
        container.classList.remove("right-panel-active");
    });
});

// Modificar la función de registro para manejar mejor los errores
document.getElementById("signupForm").addEventListener("submit", async function (event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const signupMessage = document.getElementById("signupMessage");

    try {
        const response = await fetch("../../models/php/registro.php", { // Ajustar la ruta
            method: "POST",
            body: formData
        });

        // Verificar si la respuesta es válida
        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const text = await response.text();
        let result;
        try {
            result = JSON.parse(text);
        } catch (e) {
            console.error('Respuesta del servidor:', text);
            throw new Error('Respuesta del servidor no válida');
        }

        signupMessage.style.color = result.status === 'success' ? "green" : "red";
        signupMessage.textContent = result.message;

        if (result.status === 'success') {
            // Limpiar el formulario
            event.target.reset();
            setTimeout(() => {
                container.classList.remove("right-panel-active");
            }, 2000);
        }
    } catch (error) {
        console.error('Error:', error);
        signupMessage.style.color = "red";
        signupMessage.textContent = "Error de conexión. Por favor, intenta más tarde.";
    }
});

// ... código existente ...