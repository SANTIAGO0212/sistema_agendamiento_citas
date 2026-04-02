// Variables.
const primer_nombre = document.getElementById('primer_nombre');
const segundo_nombre = document.getElementById('segundo_nombre');
const primer_apellido = document.getElementById('primer_apellido');
const segundo_apellido = document.getElementById('segundo_apellido');
const correo = document.getElementById('email');
const contrasena = document.getElementById('password');
const id_user = document.getElementById('id_user_actualizar');
const formulario_create = document.getElementById('form_create');
const modalElement = document.getElementById('exampleModal');
const modalElementActualizar = document.getElementById('exampleModalActualizar');
const modal_ver = document.getElementById('exampleModalVer');
let hayErrores = false;
const token = document.querySelector('meta[name="csrf-token"]')?.content;

function marcarError(input, mensaje) {
    input.classList.add('is-invalid');

    // Si ya existe mensaje, no lo duplicamos
    let feedback = input.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('span');
        feedback.classList.add('invalid-feedback');
        input.parentNode.appendChild(feedback);
    }

    feedback.textContent = mensaje;
}

function limpiarError(input) {
    input.classList.remove('is-invalid');

    let feedback = input.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.remove();
    }
}

// Función para guardar.
function guardar() {

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, correo].forEach(limpiarError);

    // Validaciones
    if (!primer_nombre.value.trim()) {
        marcarError(primer_nombre, 'El primer nombre es obligatorio');
        hayErrores = true;
    }

    if (!primer_apellido.value.trim()) {
        marcarError(primer_apellido, 'El primer apellido es obligatorio');
        hayErrores = true;
    }

    if (!correo.value.trim()) {
        marcarError(correo, 'El correo es obligatorio');
        hayErrores = true;
    }

    const nombre_completo = `${primer_nombre.value} ${segundo_nombre.value ?? ""} ${primer_apellido.value} ${segundo_apellido.value ?? ""}`;

    fetch('/usuarios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: nombre_completo.trim(),
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
                Swal.fire({
                    icon: "question",
                    title: "¿Está seguro de que deseas guardar los cambios?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Si, guardar.",
                    denyButtonText: `Cancelar`
                }).then((responseSwal) => {
                    if (responseSwal.isConfirmed) {
                        const email_guardado = correo.value
                        formulario_create.reset();
                        Swal.fire({
                            title: result.data.message,
                            icon: "success",
                        });
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                        const tabla = document.getElementById('tabla_usuarios');
                        const nuevaFila = `<tr>
                            <td>${nombre_completo}</td>
                            <td>${email_guardado}</td>
                        </tr>`;
                        tabla.insertAdjacentHTML('beforeend', nuevaFila);
                    }
                });
            }
        })
}

// Función para guardar y crear
function guardar_crear() {

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, correo].forEach(limpiarError);

    // Validaciones
    if (!primer_nombre.value.trim()) {
        marcarError(primer_nombre, 'El primer nombre es obligatorio');
        hayErrores = true;
    }

    if (!primer_apellido.value.trim()) {
        marcarError(primer_apellido, 'El primer apellido es obligatorio');
        hayErrores = true;
    }

    if (!correo.value.trim()) {
        marcarError(correo, 'El correo es obligatorio');
        hayErrores = true;
    }

    const nombre_completo = `${primer_nombre.value} ${segundo_nombre.value ?? ""} ${primer_apellido.value} ${segundo_apellido.value ?? ""}`;

    fetch('/usuarios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: nombre_completo.trim(),
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
                Swal.fire({
                    icon: "question",
                    title: "¿Está seguro de que deseas guardar los cambios?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Si, guardar.",
                    denyButtonText: `Cancelar`
                }).then((responseSwal) => {
                    if (responseSwal.isConfirmed) {
                        const email_guardado = correo.value
                        formulario_create.reset();
                        Swal.fire({
                            title: result.data.message,
                            icon: "success",
                        });
                        /*const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();*/
                        const tabla = document.getElementById('tabla_usuarios');
                        const nuevaFila = `<tr>
                            <td>${nombre_completo}</td>
                            <td>${email_guardado}</td>
                        </tr>`;
                        tabla.insertAdjacentHTML('beforeend', nuevaFila);
                    } else {
                        return;
                    }
                });
            }
        })
}

// Función para ver la información
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('exampleModalVer');

    modal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        // Obtener datos del botón
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const email = button.getAttribute('data-email');
        const password = button.getAttribute('data-password');

        // Separar nombre (opcional si lo tienes concatenado)
        let nombres = nombre.trim().split(' ');

        let primer_nombre_ver = '';
        let segundo_nombre_ver = '';
        let primer_apellido_ver = '';
        let segundo_apellido_ver = '';

        if (nombres.length === 2) {
            primer_nombre_ver = nombres[0];
            primer_apellido_ver = nombres[1];
        }

        if (nombres.length === 3) {
            primer_nombre_ver = nombres[0];
            segundo_nombre_ver = nombres[1];
            primer_apellido_ver = nombres[2];
        }

        if (nombres.length >= 4) {
            primer_nombre_ver = nombres[0];
            segundo_nombre_ver = nombres[1];
            primer_apellido_ver = nombres[2];
            segundo_apellido_ver = nombres.slice(3).join(' ');
        }

        document.getElementById('id_user_ver').value = id;
        document.getElementById('primer_nombre_ver').value = primer_nombre_ver || 'N/A';
        document.getElementById('segundo_nombre_ver').value = segundo_nombre_ver || 'N/A';
        document.getElementById('primer_apellido_ver').value = primer_apellido_ver || 'N/A';
        document.getElementById('segundo_apellido_ver').value = segundo_apellido_ver || 'N/A';
        document.getElementById('email_ver').value = email;
        document.getElementById('password_ver').value = password;
    });
});

//Función para rellenar los datos del formulario de editar.
document.addEventListener('DOMContentLoaded', function () {

    const modal_actualizar = document.getElementById('exampleModalActualizar');

    modal_actualizar.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        // Obtener datos del botón
        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');
        const email = button.getAttribute('data-email');
        const password = button.getAttribute('data-password');

        // Separar nombre (opcional si lo tienes concatenado)
        let nombres = nombre.trim().split(' ');

        let primer_nombre = '';
        let segundo_nombre = '';
        let primer_apellido = '';
        let segundo_apellido = '';

        if (nombres.length === 2) {
            primer_nombre = nombres[0];
            primer_apellido = nombres[1];
        }

        if (nombres.length === 3) {
            primer_nombre = nombres[0];
            segundo_nombre = nombres[1];
            primer_apellido = nombres[2];
        }

        if (nombres.length >= 4) {
            primer_nombre = nombres[0];
            segundo_nombre = nombres[1];
            primer_apellido = nombres[2];
            segundo_apellido = nombres.slice(3).join(' ');
        }

        document.getElementById('id_user_actualizar').value = id;
        document.getElementById('primer_nombre_actualizar').value = primer_nombre || '';
        document.getElementById('segundo_nombre_actualizar').value = segundo_nombre || '';
        document.getElementById('primer_apellido_actualizar').value = primer_apellido || '';
        document.getElementById('segundo_apellido_actualizar').value = segundo_apellido || '';
        document.getElementById('email_actualizar').value = email;
        document.getElementById('password_actualizar').value = password;
    });
});

function actualizar() {
    
const primer_nombre = document.getElementById('primer_nombre_actualizar');
const segundo_nombre = document.getElementById('segundo_nombre_actualizar');
const primer_apellido = document.getElementById('primer_apellido_actualizar');
const segundo_apellido = document.getElementById('segundo_apellido_actualizar');
const correo = document.getElementById('email_actualizar');
const contrasena = document.getElementById('password_actualizar');


    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [primer_nombre, segundo_nombre, primer_apellido, segundo_apellido, correo].forEach(limpiarError);

    // Validaciones
    if (!primer_nombre.value.trim()) {
        marcarError(primer_nombre, 'El primer nombre es obligatorio');
        hayErrores = true;
    }

    if (!primer_apellido.value.trim()) {
        marcarError(primer_apellido, 'El primer apellido es obligatorio');
        hayErrores = true;
    }

    if (!correo.value.trim()) {
        marcarError(correo, 'El correo es obligatorio');
        hayErrores = true;
    }

    const nombre_completo = `${primer_nombre.value} ${segundo_nombre.value ?? ""} ${primer_apellido.value} ${segundo_apellido.value ?? ""}`;

    const id = id_user.value;

    fetch(`/usuarios/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: nombre_completo.trim(),
            email: correo.value.trim(),
            password: contrasena.value ? contrasena.value.trim() : "12345678"
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
                Swal.fire({
                    icon: "question",
                    title: "¿Está seguro de que deseas guardar los cambios?",
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: "Si, guardar.",
                    denyButtonText: `Cancelar`
                }).then((responseSwal) => {
                    if (responseSwal.isConfirmed) {
                        //const email_actualizar = correo.value
                        formulario_create.reset();
                        Swal.fire({
                            title: result.data.message,
                            icon: "success",
                        });
                        document.activeElement.blur();
                        const modal_editar = bootstrap.Modal.getInstance(modalElementActualizar);
                        modal_editar.hide();
                        //const tabla = document.getElementById('tabla_usuarios');
                        const fila = document.querySelector(`tr[data-id="${id}"]`);

                        if (fila) {
                            fila.children[1].textContent = nombre_completo; // Nombre completo
                            fila.children[2].textContent = correo.value;    // Email
                        }
                    }
                });
            }
        })
}



