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
let pagina_actual = 1;
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
                        const nuevaFila = `
                            <tr id="fila_usuario_${result.data.id ?? ''}">
                                <td>${nombre_completo}</td>
                                <td>${email_guardado}</td>

                                <td class="text-center align-middle">
                                    <i class="bx bx-check-circle" style="color:green;"></i>
                                </td>

                                <td class="text-center align-middle">
                                    <a style="color: orange; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalVer"
                                        data-id="${result.data.id ?? ''}"
                                        data-nombre="${nombre_completo}"
                                        data-email="${email_guardado}">
                                        <i class="bx bx-show"></i>
                                    </a>

                                    <a style="color: purple; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalActualizar"
                                        data-id="${result.data.id ?? ''}"
                                        data-nombre="${nombre_completo}"
                                        data-email="${email_guardado}">
                                        <i class="bx bx-edit"></i>
                                    </a>

                                    <a style="color: red; cursor: pointer;"
                                        data-id="${result.data.id ?? ''}"
                                        onclick="eliminar_usuario(this)">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
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
                        const nuevaFila = `
                            <tr id="fila_usuario_${result.data.id ?? ''}">
                                <td>${nombre_completo}</td>
                                <td>${email_guardado}</td>

                                <td class="text-center align-middle">
                                    <i class="bx bx-check-circle" style="color:green;"></i>
                                </td>

                                <td class="text-center align-middle">
                                    <a style="color: orange; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalVer"
                                        data-id="${result.data.id ?? ''}"
                                        data-nombre="${nombre_completo}"
                                        data-email="${email_guardado}">
                                        <i class="bx bx-show"></i>
                                    </a>

                                    <a style="color: purple; cursor: pointer;"
                                        data-bs-toggle="modal"
                                        data-bs-target="#exampleModalActualizar"
                                        data-id="${result.data.id ?? ''}"
                                        data-nombre="${nombre_completo}"
                                        data-email="${email_guardado}">
                                        <i class="bx bx-edit"></i>
                                    </a>

                                    <a style="color: red; cursor: pointer;"
                                        data-id="${result.data.id ?? ''}"
                                        onclick="eliminar_usuario(this)">
                                        <i class="bx bx-trash"></i>
                                    </a>
                                </td>
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
        let estado = button.getAttribute('data-estado');

        // Separar nombre (opcional si lo tienes concatenado)
        let nombres = nombre.trim().split(' ');

        let primer_nombre_ver = '';
        let segundo_nombre_ver = '';
        let primer_apellido_ver = '';
        let segundo_apellido_ver = '';
        let estado_activo_ver = 'Activo';
        let estado_inactivo_ver = 'Inactivo';

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

        if(estado == 1) {
            estado = estado_activo_ver;
        }else if(estado == 0) {
            estado = estado_inactivo_ver;
        }

        document.getElementById('id_user_ver').value = id;
        document.getElementById('primer_nombre_ver').value = primer_nombre_ver || 'N/A';
        document.getElementById('segundo_nombre_ver').value = segundo_nombre_ver || 'N/A';
        document.getElementById('primer_apellido_ver').value = primer_apellido_ver || 'N/A';
        document.getElementById('segundo_apellido_ver').value = segundo_apellido_ver || 'N/A';
        document.getElementById('email_ver').value = email;
        document.getElementById('estado_ver').value = estado;
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
        const estado = button.getAttribute('data-estado');

        // Separar nombre (opcional si lo tienes concatenado)
        let nombres = nombre.trim().split(' ');

        let primer_nombre = '';
        let segundo_nombre = '';
        let primer_apellido = '';
        let segundo_apellido = '';
        let estado_activo = 'Activo';
        let estado_inactivo = 'Inactivo';

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

        if(estado === 1) {
            estado = estado_activo;
        }else if (estado === 0) {
            estado = estado_inactivo;
        }

        document.getElementById('id_user_actualizar').value = id;
        document.getElementById('primer_nombre_actualizar').value = primer_nombre || '';
        document.getElementById('segundo_nombre_actualizar').value = segundo_nombre || '';
        document.getElementById('primer_apellido_actualizar').value = primer_apellido || '';
        document.getElementById('segundo_apellido_actualizar').value = segundo_apellido || '';
        document.getElementById('email_actualizar').value = email;
        document.getElementById('estado_actualizar').value = estado_activo;
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
            //password: contrasena.value ? contrasena.value.trim() : "12345678"
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
                        const fila = document.getElementById(`fila_usuario_${id}`);

                        if (fila) {
                            fila.children[0].textContent = nombre_completo.trim();
                            fila.children[1].textContent = correo.value.trim();
                        }

                        const btnEditar = fila.querySelector('[data-bs-target="#exampleModalActualizar"]');

                        if (btnEditar) {
                            btnEditar.setAttribute('data-nombre', nombre_completo.trim());
                            btnEditar.setAttribute('data-email', correo.value.trim());
                        }

                        const btnVer = fila.querySelector('[data-bs-target="#exampleModalVer"]');

                        if (btnVer) {
                            btnVer.setAttribute('data-nombre', nombre_completo.trim());
                            btnVer.setAttribute('data-email', correo.value.trim());
                        }
                    }
                });
            }
        })
}

function eliminar_usuario(elemento) {
    const id_eliminar = elemento.dataset.id;

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    //alert(result.data.message || 'Registro exitos');
    Swal.fire({
        icon: "question",
        title: "¿Está seguro de que deseas eliminar el usuario?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si, eliminar.",
        denyButtonText: `Cancelar`
    }).then((responseSwal) => {
        if (responseSwal.isConfirmed) {
            fetch(`/usuarios/${id_eliminar}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
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

                    if (result.status === 200) {

                        Swal.fire({
                            title: result.data.message,
                            icon: "success",
                        });

                        const fila = document.getElementById(`fila_usuario_${id_eliminar}`);
                        if (fila) fila.remove();

                        const tabla = document.getElementById('tabla_usuarios_inactivos');
                        const nuevaFila = `
                            <tr id="fila_usuario_inactivo_${result.data.id ?? ''}">
                                <td>${result.data.name}</td>
                                <td>${result.data.email}</td>

                                <td class="text-center align-middle">
                                    <i class="bx bx-x-circle" style="color:red;"></i>
                                </td>

                                <td class="text-center align-middle">
                                   <a style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModalVer" data-id="${result.data.id}" data-nombre="${result.data.name}" data-email="${result.data.email}" data-estado="0"><i class="bx bx-show"></i></a>
                                   <a style="color: gold; cursor: pointer;align-items: center;" data-id="${result.data.id}" onclick="restaurar_usuario(this)"><i class="bx bx-refresh"></i></a>
                                </td>
                            </tr>`;
                        tabla.insertAdjacentHTML('beforeend', nuevaFila);
                    }

                })
        }
    });
    console.log("ID", id_eliminar);
}

function restaurar_usuario(element) {
    const id_restaurar = element.dataset.id;

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    //alert(result.data.message || 'Registro exitos');
    Swal.fire({
        icon: "question",
        title: "¿Está seguro de que deseas restaurar el usuario?",
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: "Si, restaurar.",
        denyButtonText: `Cancelar`
    }).then((responseSwal) => {
        if (responseSwal.isConfirmed) {
            fetch(`/usuarios/restaurar/${id_restaurar}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
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

                    if (result.status === 200) {

                        Swal.fire({
                            title: result.data.message,
                            icon: "success",
                        });

                        const fila = document.getElementById(`fila_usuario_inactivo_${id_restaurar}`);
                        if (fila) fila.remove();

                        const tabla = document.getElementById('tabla_usuarios');
                        const nuevaFila = `
                            <tr id="fila_usuario_${result.data.id ?? ''}">
                                <td>${result.data.name}</td>
                                <td>${result.data.email}</td>

                                <td class="text-center align-middle">
                                    <i class="bx bx-check-circle" style="color:green;"></i>
                                </td>

                            <td class="text-center align-middle">
                                <a style="color: orange; cursor: pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalVer"
                                    data-id="${result.data.id}"
                                    data-nombre="${result.data.name}"
                                    data-email="${result.data.email}"
                                    data-estado="1">
                                    <i class="bx bx-show"></i>
                                </a>

                                <a style="color: purple; cursor: pointer;"
                                    data-bs-toggle="modal"
                                    data-bs-target="#exampleModalActualizar"
                                    data-id="${result.data.id}"
                                    data-nombre="${result.data.name}"
                                    data-email="${result.data.email}"
                                    data-estado="{{ ${result.data.estado} }}">
                                    <i class="bx bx-edit"></i>
                                </a>

                                <a style="color: red; cursor: pointer;"
                                    data-id="${result.data.id}"
                                    onclick="eliminar_usuario(this)">
                                    <i class="bx bx-trash"></i>
                                </a>
                            </td>
                                </td>
                            </tr>`;
                        tabla.insertAdjacentHTML('beforeend', nuevaFila);
                    }
                })
        }
    });
    console.log("ID", id_restaurar);
}


// PROCESO PARA EL LISTAR Y LA PAGINACIÓN


document.addEventListener('DOMContentLoaded', function () {

    renderPaginacion(paginadorInicial);

    // 🔹 Eventos
    document.getElementById('input_buscar').addEventListener('keyup', function () {
        pagina_actual = 1;
        listarUsuarios();
    });

    document.getElementById('select_por_pagina').addEventListener('change', function () {
        pagina_actual = 1;
        listarUsuarios();
    });

});

function listarUsuarios(page = 1) {

    pagina_actual = page;

    const buscar = document.getElementById('input_buscar').value;
    const porPagina = document.getElementById('select_por_pagina').value;

    fetch(`/usuarios/activo?buscar=${buscar}&porPagina=${porPagina}&page=${page}`)
        .then(response => response.json())
        .then(result => {

            if (result.status === 'success') {

                renderTabla(result.usuarios.data);
                renderPaginacion(result.usuarios);

            } else {
                console.error(result);
            }

        })
        .catch(error => console.error('Error:', error));
}

function renderTabla(usuarios) {

    const tabla = document.getElementById('tabla_usuarios');
    tabla.innerHTML = '';

    usuarios.forEach(usuario => {

        let estadoIcono = usuario.estado == 1
            ? '<i class="bx bx-check-circle" style="color:green;"></i>'
            : '<i class="bx bx-x-circle" style="color:red;"></i>';

        tabla.innerHTML += `
            <tr id="fila_usuario_${usuario.id}">
                <td>${usuario.name}</td>
                <td>${usuario.email}</td>

                <td class="text-center align-middle">
                    ${estadoIcono}
                </td>

                <td class="text-center align-middle">

                    <a style="color: orange; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalVer"
                        data-id="${usuario.id}"
                        data-nombre="${usuario.name}"
                        data-email="${usuario.email}"
                        data-estado="${usuario.estado}">
                        <i class="bx bx-show"></i>
                    </a>

                    <a style="color: purple; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalActualizar"
                        data-id="${usuario.id}"
                        data-nombre="${usuario.name}"
                        data-email="${usuario.email}"
                        data-estado="${usuario.estado}">
                        <i class="bx bx-edit"></i>
                    </a>

                    <a style="color: red; cursor: pointer;"
                        data-id="${usuario.id}"
                        onclick="eliminar_usuario(this)">
                        <i class="bx bx-trash"></i>
                    </a>

                </td>
            </tr>
        `;
    });
}

function renderPaginacion(paginador) {

    const contenedor = document.getElementById('paginacion');
    contenedor.innerHTML = '';

    let botones = '';

    // 🔹 SIEMPRE mostrar al menos la página 1
    const totalPaginas = paginador.last_page || 1;

    // 🔹 Botón anterior (aunque sea una sola página)
    botones += `
        <button class="btn btn-sm btn-light me-1"
            ${paginador.current_page == 1 ? 'disabled' : ''}
            onclick="listarUsuarios(${paginador.current_page - 1})">
            «
        </button>
    `;

    // 🔹 Números de página
    for (let i = 1; i <= totalPaginas; i++) {
        botones += `
            <button class="btn btn-sm ${i === paginador.current_page ? 'btn-dark' : 'btn-light'} me-1"
                onclick="listarUsuarios(${i})">
                ${i}
            </button>
        `;
    }

    // 🔹 Botón siguiente
    botones += `
        <button class="btn btn-sm btn-light"
            ${paginador.current_page == totalPaginas ? 'disabled' : ''}
            onclick="listarUsuarios(${paginador.current_page + 1})">
            »
        </button>
    `;

    contenedor.innerHTML = botones;
}