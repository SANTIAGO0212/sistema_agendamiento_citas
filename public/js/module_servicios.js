// Variables.
const nombre = document.getElementById('nombre');
const descripcion = document.getElementById('descripcion');
const id_servicio = document.getElementById('id_servicio_actualizar');
const formulario_create = document.getElementById('form_create');
const modalElement = document.getElementById('exampleModal');
const modalElementActualizar = document.getElementById('exampleModalActualizar');
const modal_ver = document.getElementById('exampleModalVer');
const selected = document.querySelector(".selected");
const input_precio = document.querySelector(".input_precio");
let hayErrores = false;
let pagina_actual = 1;
const token = document.querySelector('meta[name="csrf-token"]')?.content;

function marcarError(input, mensaje, textarea) {
    input.classList.add('is-invalid');
    textarea.classList.add('is-invalid');

    // Si ya existe mensaje, no lo duplicamos
    let feedback = input.nextElementSibling;
    let feedback_area = textarea.nextElementSibling;
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
        feedback = document.createElement('span');
        feedback.classList.add('invalid-feedback');
        input.parentNode.appendChild(feedback);   
    }

    if (!feedback_area || !feedback_area.classList.contains('invalid-feedback')) {
        feedback_area = document.createElement('span');
        feedback_area.classList.add('invalid-feedback');
        textarea.parentNode.appendChild(feedback);   
    }

    feedback.textContent = mensaje;
    feedback_area.textContent = mensaje;
}

selected.addEventListener('click', function () {
    if (this.checked) {
        input_precio.classList.remove('oculto');
    } else {
        input_precio.classList.add('oculto');
    }
});

function limpiarError(input, textarea) {
    input.classList.remove('is-invalid');
    textarea.classList.remove('is-invalid')

    let feedback = input.nextElementSibling;
    let feedback_area = textarea.nextElementSibling;
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.remove();
    }

    /*if (feedback_area && feedback_area.classList.contains('invalid-feedback')) {
        feedback_area.remove();
    }*/
}

// Función para guardar.
function guardar_servicio() {

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [nombre, descripcion].forEach(limpiarError);

    // Validaciones
    if (!nombre.value.trim()) {
        marcarError(nombre, 'El nombre de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!descripcion.value.trim()) {
        marcarError(descripcion, 'La descripción es obligatoria');
        hayErrores = true;
    }

    fetch('/servicios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre.value.trim(),
            descripcion: descripcion.value.trim(),
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
                        formulario_create.reset();
                        Swal.fire({
                            title: result.data.message,
                            icon: "success",
                        });
                        const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();
                        listarServicios(pagina_actual);

                        // llamando esta función se agregará de forma automática a la tabla sin necesidad de recargar la página.
                        // esto debido que constantemente se está consultando del lado del servidor los resultados de la lista.
                        // Por lo que más adelante se ajustará automáticamente al paginador.
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
    [nombre, descripcion].forEach(limpiarError);

    // Validaciones

    if (!nombre.value.trim()) {
        marcarError(nombre, 'El nombre de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!descripcion.value.trim()) {
        marcarError(descripcion, 'La descripción es obligatoria');
        hayErrores = true;
    }

    fetch('/servicios', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre.value.trim(),
            descripcion: descripcion.value.trim(),
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
                        formulario_create.reset();
                        Swal.fire({
                            title: result.data.message,
                            icon: "success",
                        });
                        /*const modal = bootstrap.Modal.getInstance(modalElement);
                        modal.hide();*/
                        listarServicios(pagina_actual);

                        // llamando esta función se agregará de forma automática a la tabla sin necesidad de recargar la página y podrás seguir agregando más información 
                        // ya que en esta ocasión el modal se cerrará de forma automática del lado del usuario.
                        // esto debido que constantemente se está consultando del lado del servidor los resultados de la lista.
                        // Por lo que más adelante se ajustará automáticamente al paginador.

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
        const nombre_ver = button.getAttribute('data-nombre');
        const descripcion_ver = button.getAttribute('data-descripcion');
        let estado = button.getAttribute('data-estado');

        // Separar nombre (opcional si lo tienes concatenado)

        let estado_activo_ver = 'Activo';
        let estado_inactivo_ver = 'Inactivo';

        if (estado == 1) {
            estado = estado_activo_ver;
        } else if (estado == 0) {
            estado = estado_inactivo_ver;
        }

        document.getElementById('id_servicio_ver').value = id;
        document.getElementById('nombre_ver').value = nombre_ver || 'N/A';
        document.getElementById('estado_ver').value = estado;
        document.getElementById('descripcion_ver').value = descripcion_ver;

    });
});

//Función para rellenar los datos del formulario de editar.
document.addEventListener('DOMContentLoaded', function () {

    const modal_actualizar = document.getElementById('exampleModalActualizar');

    modal_actualizar.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        // VALIDAR SI EL BOTÓN EXISTE
        if (!button) {
            console.error('No se encontró el botón que abrió el modal');
            return;
        }

        // Obtener datos del botón
        const id = button.getAttribute('data-id');
        const nombre_actualizar = button.getAttribute('data-nombre') || '';
        const descripcion_actualizar = button.getAttribute('data-descripcion');
        let estado = 'Activo';

        document.getElementById('id_sucursal_actualizar').value = id || '';
        document.getElementById('nombre_actualizar').value = nombre_actualizar || '';
        document.getElementById('descripcion_actualizar').value = descripcion_actualizar || '';
        document.getElementById('estado_actualizar').value = estado;
    });
});

function actualizar() {

    const nombre_actualizar = document.getElementById('nombre_actualizar');
    const descripcion_actualizar = document.getElementById('descripcion_actualizar');


    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [nombre_actualizar, descripcion_actualizar].forEach(limpiarError);

    // Validaciones
    if (!nombre_actualizar.value.trim()) {
        marcarError(nombre_actualizar, 'El primer nombre es obligatorio');
        hayErrores = true;
    }

    if (!descripcion_actualizar.value.trim()) {
        marcarError(direccion_actualizar, 'La descripción es obligatoria');
        hayErrores = true;
    }

    const id = id_servicio.value;

    fetch(`/servicios/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre_actualizar.value.trim(),
            descripcion: descripcion.value.trim(),
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
                        const fila = document.getElementById(`fila_servicio_${id}`);

                        if (fila) {
                            fila.children[0].textContent = nombre_actualizar.value.trim();
                            fila.children[1].textContent = descripcion_actualizar.value.trim();
                        }

                        const btnEditar = fila.querySelector('[data-bs-target="#exampleModalActualizar"]');

                        if (btnEditar) {
                            btnEditar.setAttribute('data-nombre', nombre_actualizar.value.trim());
                            btnEditar.setAttribute('data-descripcion', descripcion_actualizar.value.trim());
                        }

                        const btnVer = fila.querySelector('[data-bs-target="#exampleModalVer"]');

                        if (btnVer) {
                            btnVer.setAttribute('data-nombre', nombre_actualizar.value.trim());
                            btnVer.setAttribute('data-descripcion', descripcion_actualizar.value.trim());
                        }
                    }
                });
            }
        })
}

function eliminar_servicio(elemento) {
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
            fetch(`/servicios/${id_eliminar}`, {
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

                        /*const fila = document.getElementById(`fila_usuario_${id_eliminar}`);
                        if (fila) fila.remove(); */

                        /*const filas_actuales = document.querySelectorAll('#tabla_usuarios tr').length;

                        if(filas_actuales === 1 && pagina_actual>1) {
                            pagina_actual--;
                        }*/
                        listarServicios(pagina_actual); //Se llaman estas funciones para la actualización del conteo de los respectivos paginadores.
                                                         // el cuál se eliminará la fila de la tabla de usuarios activos y a su vez de forma automática se actualizará el paginador en la tabla de usuarios inactivos.
                    }
                })
        }
    });
    
}

// PROCESO PARA EL LISTAR Y LA PAGINACIÓN

document.addEventListener('DOMContentLoaded', function () {

    listarServicios(); // Se llaman las funciones para que constantemente se estén validando los paginadores.

    let timeout_busqueda = null;
    
    document.getElementById('input_buscar').addEventListener('keyup', function () {
        pagina_actual = 1;
        clearTimeout(timeout_busqueda);

        timeout_busqueda= setTimeout(() => {
            listarServicios();
        }, 400)
    });

    document.getElementById('select_por_pagina').addEventListener('change', function () {
        pagina_actual = 1;
        listarServicios();
    });

});

function listarServicios(page = 1) {

    pagina_actual = page;
    let controladorBusqueda = null;

    const buscar = document.getElementById('input_buscar').value;
    const porPagina = document.getElementById('select_por_pagina').value;

    if(controladorBusqueda) {
        controladorBusqueda.abort();
    }

    controladorBusqueda = new AbortController();

    fetch(`/servicios?buscar=${encodeURIComponent(buscar)}&porPagina=${porPagina}&page=${page}`, {
            signal: controladorBusqueda.signal
           })
        .then(response => response.json())
        .then(result => {

            if (result.status === 'success') {

                if(pagina_actual>1 && pagina_actual > result.sucursales.last_page){
                    pagina_actual = result.sucursales.last_page;
                    listarServicios(pagina_actual);
                    return;

                    // Se genera esta validación en caso de que al eliminar todos los registros de una página esta retorne a la página anterio.
                    // y la página actual desaparecerá, cabe aclarar que esto únicamente aplicará si hay más de 1 página con registros, en caso
                    // de que haya únicamente 1 página esta validación no se hará.
                }

                renderTabla(result.servicios.data);
                renderPaginacion(result.servicios);

            }
        })
        .catch(error => {

            if (error.name !== 'AbortError') {
                console.error('Error:', error);
            }

        });
}

function renderTabla(servicios) {

    const tabla = document.getElementById('tabla_servicios');
    tabla.innerHTML = '';

    // Si no hay registros

    if(servicios.length === 0) {
        tabla.innerHTML = `
           <tr>
             <td colspan = "4" class="text-center text-muted py-2">
               No hay resultados en este momento.
             </td>
           </tr>
        `;

        return;
    }

    servicios.forEach(servicio => {

        let estadoIcono = servicio.estado == 1
            ? '<i class="bx bx-check-circle" style="color:green;"></i>'
            : '<i class="bx bx-x-circle" style="color:red;"></i>';

        tabla.innerHTML += `
            <tr id="fila_servicio_${servicio.id}">
                <td>${servicio.nombre}</td>
                <td>${servicio.descripcion}</td>

                <td class="text-center align-middle">
                    ${estadoIcono}
                </td>

                <td class="text-center align-middle">

                    <a style="color: orange; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalVer"
                        data-id="${sucursal.id}"
                        data-nombre="${sucursal.nombre}"
                        data-descripcion="${sucursal.descripcion}"
                        data-estado="1">
                        <i class="bx bx-show"></i>
                    </a>

                    <a style="color: purple; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalActualizar"
                        data-id="${sucursal.id}"
                        data-nombre="${sucursal.nombre}"
                        data-descripcion="${sucursal.descripcion}"
                        data-estado="1">
                        <i class="bx bx-edit"></i>
                    </a>

                    <a style="color: red; cursor: pointer;"
                        data-id="${sucursal.id}"
                        onclick="eliminar_servicio(this)">
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

    // SIEMPRE mostrar al menos la página 1
    const totalPaginas = paginador.last_page || 1;

    // Botón anterior (aunque sea una sola página)
    botones += `
        <button class="btn btn-sm btn-light me-1"
            ${paginador.current_page == 1 ? 'disabled' : ''}
            onclick="listarUsuariosActivos(${paginador.current_page - 1})">
            «
        </button>
    `;
    // Números de página
    for (let i = 1; i <= totalPaginas; i++) {
        botones += `
            <button class="btn btn-sm ${i === paginador.current_page ? 'btn-dark' : 'btn-light'} me-1"
                onclick="listarServicios(${i})">
                ${i}
            </button>
        `;
    }
    // Botón siguiente
    botones += `
        <button class="btn btn-sm btn-light"
            ${paginador.current_page == totalPaginas ? 'disabled' : ''}
            onclick="listarServicios(${paginador.current_page + 1})">
            »
        </button>
    `;
    contenedor.innerHTML = botones;
}