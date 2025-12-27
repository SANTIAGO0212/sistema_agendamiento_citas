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

    if (!nombre.value.trim()) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "Por favor, ingresa tu nombre completo."
        })

        return;
    }

    if (!correo.value.trim()) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "Por favor, ingresa tu correo electrónico."
        })

        return;
    }

    if (!contrasena.value.trim()) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "Por favor, ingresa la contraseña."
        })

        return;
    }

    if (contrasena.value.length > 12) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "La contraseña debe ser máximo de 12 carácteres."
        });

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
                //alert(result.data.message || 'Registro exitos');
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: result.data.message
                }).then(() => {
                    document.getElementById('formulario_registro').reset();
                    window.location.href = '/dashboards/index_admin'
                });
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

    if (!correo.trim()) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "Por favor, ingresa tu correo electrónico."
        })

        return;
    }

    if (!contrasena.trim()) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "Por favor, ingresa la contraseña."
        })

        return;
    }

    if (contrasena.length > 12) {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: "error",
            title: "La contraseña debe ser máximo de 12 carácteres."
        });

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
                //alert(result.data.message || 'Credenciales correctas');
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "success",
                    title: result.data.message
                }).then(() => {
                    document.getElementById('formulario_registro').reset();
                    window.location.href = '/dashboards/index_admin'
                });
            } else if (result.status === 401 || result.status === 402) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                });
                Toast.fire({
                    icon: "error",
                    title: result.data.message
                });
            }
        })
}