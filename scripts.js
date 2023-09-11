function login(event) {
    event.preventDefault();

    const usuario = document.getElementById('usuario').value;
    const pass = document.getElementById('pass').value;

    const data = {
        username: usuario,
        password: pass
    };

    fetch('https://api.selecu.net/api-selecu/auth/students', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then(result => {

            localStorage.setItem('id', result.id);
            localStorage.setItem('token', result.token);

            if (result.message === "Autenticación correcta") {
                abrirEnNuevaPestana();
            }
            else {
                const mensajeElemento = document.getElementById('mensaje');
                mensajeElemento.textContent = 'Error de Usuario y/o Contraseña';
            }

        })
        .catch(error => {
            console.error('Error:', error);
        });
}

document.getElementById('formulario').addEventListener('submit', login);

function abrirEnNuevaPestana() {
    window.open('indexInd.html', '_blank');
}