const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

// Función para registrarse.

function registrarse() {
    const nombre = document.getElementById('name');
    const correo = document.getElementById('email');
    const contrasena = document.getElementById('password');
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    fetch('/register', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: nombre.value.trim(),
            email: correo.value.trim(),
            password: contrasena.value.trim()
        })
    })
        .then(response => {
            console.log('Respuesta recibida', response.status);
            return response.json().then(data => {
                return {
                    status: response.status,
                    data: data
                };
            });
        })
        .then(result => {
            console.log('Resultado del procesado', result);

            if (result.status === 201 || result.status === 200) {
                alert(result.data.message || 'Registro exitos');
                console.log('Token recibido:', result.data.token);
                console.log('Usuario:', result.data.user);
            }
        })
}

// Función para iniciar sesión

function iniciar_sesion() {
    const correo = document.getElementById('email_login').value;
    const contrasena = document.getElementById('password_login').value;
    const token = document.querySelector('meta[name="csrf-token"]')?.content;

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    fetch('/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            email: correo.trim(),
            password: contrasena.trim()
        })
    })

        .then(response => {
            console.log('Respuesta recibida', response.status);
            return response.json().then(data => {
                return {
                    status: response.status,
                    data: data
                };
            });
        })
        .then(result => {
            console.log('Resultado del procesado', result);

            if (result.status === 201 || result.status === 200) {
                alert(result.data.message || 'Credenciales correctas');
                console.log('Token recibido:', result.data.token);
                console.log('Usuario:', result.data.user);
            }
        })
}