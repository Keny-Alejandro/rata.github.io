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

            console.log(result);
            if (result.message === "Autenticación correcta") {
                window.location.href = 'index.html';
            }

        })
        .catch(error => {
            console.error('Error:', error);
        });
}

document.getElementById('formulario').addEventListener('submit', login);