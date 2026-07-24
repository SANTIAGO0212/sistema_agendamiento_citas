// Variables.
const nombre = document.getElementById('nombre');
const telefono = document.getElementById('telefono');
const direccion = document.getElementById('direccion');
const id_sucursal = document.getElementById('id_sucursal_actualizar');
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
function guardar_sucursal() {

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [nombre, direccion, telefono].forEach(limpiarError);

    // Validaciones
    if (!nombre.value.trim()) {
        marcarError(nombre, 'El nombre de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!telefono.value.trim()) {
        marcarError(telefono, 'El teléfono de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!direccion.value.trim()) {
        marcarError(direccion, 'La dirección de la sucursal es obligatorio');
        hayErrores = true;
    }

    fetch('/sucursales', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre.value.trim(),
            telefono: telefono.value.trim(),
            direccion: direccion.value.trim()
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
                        listarSucursales(pagina_actual);

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
    [nombre, direccion, telefono].forEach(limpiarError);

    // Validaciones

    if (!nombre.value.trim()) {
        marcarError(nombre, 'El nombre de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!telefono.value.trim()) {
        marcarError(telefono, 'El teléfono de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!direccion.value.trim()) {
        marcarError(direccion, 'La dirección de la sucursal es obligatoria');
        hayErrores = true;
    }

    fetch('/sucursales', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre.value.trim(),
            telefono: telefono.value.trim(),
            direccion: direccion.value.trim()
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
                        listarSucursales(pagina_actual);

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
        const direccion_ver = button.getAttribute('data-direccion');
        const telefono_ver = button.getAttribute('data-telefono');
        let estado = button.getAttribute('data-estado');

        // Separar nombre (opcional si lo tienes concatenado)

        let estado_activo_ver = 'Activo';
        let estado_inactivo_ver = 'Inactivo';

        if (estado == 1) {
            estado = estado_activo_ver;
        } else if (estado == 0) {
            estado = estado_inactivo_ver;
        }

        document.getElementById('id_sucursal_ver').value = id;
        document.getElementById('nombre_ver').value = nombre_ver || 'N/A';
        document.getElementById('estado_ver').value = estado;
        document.getElementById('direccion_ver').value = direccion_ver;
        document.getElementById('telefono_ver').value = telefono_ver;

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
        const direccion = button.getAttribute('data-direccion');
        const telefono_editar = button.getAttribute('data-telefono');
        let estado = 'Activo';

        document.getElementById('id_sucursal_actualizar').value = id || '';
        document.getElementById('nombre_actualizar').value = nombre_actualizar || '';
        document.getElementById('direccion_actualizar').value = direccion || '';
        document.getElementById('telefono_actualizar').value = telefono_editar || '';
        document.getElementById('estado_actualizar').value = estado;
    });
});

function actualizar() {

    const nombre_actualizar = document.getElementById('nombre_actualizar');
    const telefono_actualizar = document.getElementById('telefono_actualizar');
    const direccion_actualizar = document.getElementById('direccion_actualizar');


    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [nombre_actualizar, telefono_actualizar, direccion_actualizar].forEach(limpiarError);

    // Validaciones
    if (!nombre_actualizar.value.trim()) {
        marcarError(nombre_actualizar, 'El primer nombre es obligatorio');
        hayErrores = true;
    }

    if (!telefono_actualizar.value.trim()) {
        marcarError(telefono_actualizar, 'El correo es obligatorio');
        hayErrores = true;
    }

    if (!direccion_actualizar.value.trim()) {
        marcarError(direccion_actualizar, 'El correo es obligatorio');
        hayErrores = true;
    }

    const id = id_sucursal.value;

    fetch(`/sucursales/${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            nombre: nombre_actualizar.value.trim(),
            direccion: direccion_actualizar.value.trim(),
            telefono: telefono_actualizar.value.trim(),
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
                        const fila = document.getElementById(`fila_sucursal_${id}`);

                        if (fila) {
                            fila.children[0].textContent = nombre_actualizar.value.trim();
                            fila.children[1].textContent = direccion_actualizar.value.trim();
                            fila.children[2].textContent = telefono_actualizar.value.trim();
                        }

                        const btnEditar = fila.querySelector('[data-bs-target="#exampleModalActualizar"]');

                        if (btnEditar) {
                            btnEditar.setAttribute('data-nombre', nombre_actualizar.value.trim());
                            btnEditar.setAttribute('data-direccion', direccion_actualizar.value.trim());
                            btnEditar.setAttribute('data-telefono', telefono_actualizar.value.trim());
                        }

                        const btnVer = fila.querySelector('[data-bs-target="#exampleModalVer"]');

                        if (btnVer) {
                            btnVer.setAttribute('data-nombre', nombre_actualizar.value.trim());
                            btnVer.setAttribute('data-telefono', telefono_actualizar.value.trim());
                            btnVer.setAttribute('data-direccion', direccion_actualizar.value.trim());
                        }
                    }
                });
            }
        })
}

function eliminar_sucursal(elemento) {
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
            fetch(`/sucursales/${id_eliminar}`, {
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
                        listarSucursales(pagina_actual); //Se llaman estas funciones para la actualización del conteo de los respectivos paginadores.
                                                         // el cuál se eliminará la fila de la tabla de usuarios activos y a su vez de forma automática se actualizará el paginador en la tabla de usuarios inactivos.
                    }
                })
        }
    });
    
}

// PROCESO PARA EL LISTAR Y LA PAGINACIÓN

document.addEventListener('DOMContentLoaded', function () {

    listarSucursales(); // Se llaman las funciones para que constantemente se estén validando los paginadores.

    let timeout_busqueda = null;
    
    document.getElementById('input_buscar').addEventListener('keyup', function () {
        pagina_actual = 1;
        clearTimeout(timeout_busqueda);

        timeout_busqueda= setTimeout(() => {
            listarSucursales();
        }, 400)
    });

    document.getElementById('select_por_pagina').addEventListener('change', function () {
        pagina_actual = 1;
        listarSucursales();
    });

});

function listarSucursales(page = 1) {

    pagina_actual = page;
    let controladorBusqueda = null;

    const buscar = document.getElementById('input_buscar').value;
    const porPagina = document.getElementById('select_por_pagina').value;

    if(controladorBusqueda) {
        controladorBusqueda.abort();
    }

    controladorBusqueda = new AbortController();

    fetch(`/sucursales?buscar=${encodeURIComponent(buscar)}&porPagina=${porPagina}&page=${page}`, {
            signal: controladorBusqueda.signal
           })
        .then(response => response.json())
        .then(result => {

            if (result.status === 'success') {

                if(pagina_actual>1 && pagina_actual > result.sucursales.last_page){
                    pagina_actual = result.sucursales.last_page;
                    listarSucursales(pagina_actual);
                    return;

                    // Se genera esta validación en caso de que al eliminar todos los registros de una página esta retorne a la página anterio.
                    // y la página actual desaparecerá, cabe aclarar que esto únicamente aplicará si hay más de 1 página con registros, en caso
                    // de que haya únicamente 1 página esta validación no se hará.
                }

                renderTabla(result.sucursales.data);
                renderPaginacion(result.sucursales);

            }
        })
        .catch(error => {

            if (error.name !== 'AbortError') {
                console.error('Error:', error);
            }

        });
}

function renderTabla(sucursales) {

    const tabla = document.getElementById('tabla_sucursales');
    tabla.innerHTML = '';

    // Si no hay registros

    if(sucursales.length === 0) {
        tabla.innerHTML = `
           <tr>
             <td colspan = "5" class="text-center text-muted py-2">
               No hay resultados en este momento.
             </td>
           </tr>
        `;

        return;
    }

    sucursales.forEach(sucursal => {

        let estadoIcono = sucursal.estado == 1
            ? '<i class="bx bx-check-circle" style="color:green;"></i>'
            : '<i class="bx bx-x-circle" style="color:red;"></i>';

        tabla.innerHTML += `
            <tr id="fila_sucursal_${sucursal.id}">
                <td>${sucursal.nombre}</td>
                <td>${sucursal.direccion}</td>
                <td>${sucursal.telefono}</td>

                <td class="text-center align-middle">
                    ${estadoIcono}
                </td>

                <td class="text-center align-middle">

                    <a style="color: orange; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalVer"
                        data-id="${sucursal.id}"
                        data-nombre="${sucursal.nombre}"
                        data-direccion="${sucursal.direccion}"
                        data-telefono="${sucursal.telefono}"
                        data-estado="1">
                        <i class="bx bx-show"></i>
                    </a>

                    <a style="color: purple; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalActualizar"
                        data-id="${sucursal.id}"
                        data-nombre="${sucursal.nombre}"
                        data-direccion="${sucursal.direccion}"
                        data-telefono="${sucursal.telefono}"
                        data-estado="1">
                        <i class="bx bx-edit"></i>
                    </a>

                    <a style="color: red; cursor: pointer;"
                        data-id="${sucursal.id}"
                        onclick="eliminar_sucursal(this)">
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
            onclick="listarUsuariosActivos(${paginador.current_page - 1})">
            «
        </button>
    `;

    // 🔹 Números de página
    for (let i = 1; i <= totalPaginas; i++) {
        botones += `
            <button class="btn btn-sm ${i === paginador.current_page ? 'btn-dark' : 'btn-light'} me-1"
                onclick="listarSucursales(${i})">
                ${i}
            </button>
        `;
    }

    // 🔹 Botón siguiente
    botones += `
        <button class="btn btn-sm btn-light"
            ${paginador.current_page == totalPaginas ? 'disabled' : ''}
            onclick="listarSucursales(${paginador.current_page + 1})">
            »
        </button>
    `;

    contenedor.innerHTML = botones;
}

// GEOLOCALIZACIÓN

let map;
let marker;

let latitud;
let longitud;

const modalMapa = document.getElementById('abrirModalMapa');

modalMapa.addEventListener('show.bs.modal', function () {
    if(!map) {
        map = L.map('map');

        map.setView([6.2441, -75.5812], 13);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '© OpenStreetMap'}).addTo(map);

        if(navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(posicion) {
                latitud = posicion.coords.latitude;
                longitud = posicion.coords.longitude;
                
                map.setView([latitud,longitud],17);

                marker = L.marker([latitud,longitud], {draggable:true}).addTo(map);

                marker.on('dragend', function(e) {
                    latitud = e.target.getLatLng().lat;
                    longitud = e.target.getLatLng().lng;
                });
            });
        }

        map.on('click', function(e) {
            latitud = e.latlng.lat;
            longitud = e.latlng.lng;

            if(marker) {
                marker.setLatLng(e.latlng);
            }else {
                marker = L.marker(e.latlng, {draggable:true}).addTo(map);

                marker.on('dragend', function(e) {
                    latitud = e.target.getLatLng().lat;
                    longitud = e.target.getLatLng().lng;
                });
            }
        });
    }

    setTimeout(function() {
        map.invalidateSize();
    }, 300)
});

document.getElementById('guardarDireccion').addEventListener("click", function() {
    if(!latitud) {
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
            icon: "warning",
            title: "Por favor, seleccione una nueva ubicación."
        })

        return;
    }

    document.querySelectorAll(".latitud").value = latitud;
    document.querySelectorAll(".longitud").value = longitud;

    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitud}&lon=${longitud}`)
        .then(response=> response.json())
        .then(data => {
            let direccion_precisa = data.address.road ?? "";

            if(data.address.house_number) {
                direccion_precisa += "#" + data.address.house_number;
            }else {
                direccion_precisa += ',' + data.address.neighbourhood + ',' + data.address.suburb;
            }

            document.getElementById("direccion").value = direccion_precisa;
            document.getElementById("direccion_actualizar").value = direccion_precisa
            //document.getElementById("direccion").value = data.address.road + '#' + data.address.house_number;

            //bootstrap.Modal.getInstance('abrirModalMapa').hide();
            const modalMaps = bootstrap.Modal.getOrCreateInstance(document.getElementById('abrirModalMapa'));
            modalMaps.hide();

            document.body.classList.add('modal-open');
        });
});

document.querySelectorAll(".btnAbrirMapa").forEach(btn => {
    btn.addEventListener("click", function() {
        const modalMapas = new bootstrap.Modal(document.getElementById("abrirModalMapa"),{
            backdrop: 'static',
            keyboard: false
        });

        modalMapas.show();
        document.body.classList.add('modal-open');

        setTimeout(() => {map?.invalidateSize},300);
    });
});