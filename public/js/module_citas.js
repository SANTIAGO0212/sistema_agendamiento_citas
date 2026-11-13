// Variables.
const nombre = document.getElementById('nombre');
const descripcion = document.getElementById('descripcion');
const id_servicio = document.getElementById('id_servicio_actualizar');
const formulario_create = document.getElementById('form_create');
const modalElement = document.getElementById('exampleModal');
const modalElementActualizar = document.getElementById('exampleModalActualizar');
const modal_ver = document.getElementById('exampleModalVer');
const selected = document.querySelector(".selected");
const selected_actualizar = document.querySelector(".selected_actualizar");
const input_precio = document.querySelector(".input_precio");
const input_precio_actualizar = document.querySelector(".input_precio_actualizar");
const precio_inicial = document.querySelector(".precio_inicial");
const descuento = document.querySelector(".descuento");
const precio_total = document.querySelector(".precio_total");
let hayErrores = false;
let pagina_actual = 1;
let seleccionado = 0;
let descuento_aplicado = 0;
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

selected.addEventListener('click', function () {
    if (this.checked) {
        input_precio.classList.remove('oculto');
    } else {
        input_precio.classList.add('oculto');
    }
});

function limpiarError(input) {
    input.classList.remove('is-invalid');

    let feedback = input.nextElementSibling;
    
    if (feedback && feedback.classList.contains('invalid-feedback')) {
        feedback.remove();
    }
}

// Función para guardar.
function guardar_servicio() {

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [nombre, descripcion, precio_inicial].forEach(limpiarError);

    // Validaciones
    if (!nombre.value.trim()) {
        marcarError(nombre, 'El nombre de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!descripcion.value.trim()) {
        marcarError(descripcion, 'La descripción es obligatoria');
        hayErrores = true;
    }

    if (!precio_inicial.value.trim()) {
        marcarError(precio_inicial, 'Debes ingresar el precio del servicio');
        hayErrores = true;
    }

    if(selected.checked) {
        seleccionado = 1
    }
    else if (!selected.checked) {
        seleccionado = 0
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
           valor_inicial: parseFloat(precio_inicial.value.replace(/[^\d,-]/g, '').replace(/\./g, '').replace(',', '.')).toFixed(2),
           descuento: seleccionado,
           valor_descuento: parseFloat(descuento.value).toFixed(2) || 0.00,
           valor_total: parseFloat(precio_total.value.replace(/[^\d,-]/g, '').replace(/\./g, '').replace(',', '.')).toFixed(2)
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
    [nombre, descripcion, precio_inicial].forEach(limpiarError);

    // Validaciones

    if (!nombre.value.trim()) {
        marcarError(nombre, 'El nombre de la sucursal es obligatorio');
        hayErrores = true;
    }

    if (!descripcion.value.trim()) {
        marcarError(descripcion, 'La descripción es obligatoria');
        hayErrores = true;
    }

    if (!precio_inicial.value.trim()) {
        marcarError(precio_inicial, 'Debes ingresar el precio del servicio');
        hayErrores = true;
    }

    if(selected.checked) {
        seleccionado = 1
    }
    else if (!selected.checked) {
        seleccionado = 0
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
           valor_inicial: parseFloat(precio_inicial.value.replace(/[^\d,-]/g, '').replace(/\./g, '').replace(',', '.')).toFixed(2),
           descuento: seleccionado,
           valor_descuento: descuento.value.trim() === '' ? '0.00' : parseFloat(descuento.value).toFixed(2),
           valor_total: parseFloat(precio_total.value.replace(/[^\d,-]/g, '').replace(/\./g, '').replace(',', '.')).toFixed(2)
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
        const valor_inicial_ver = button.getAttribute('data-valor_inicial');
        const valor_descuento_ver = button.getAttribute('data-valor_descuento');
        const valor_total_ver = button.getAttribute('data-valor_total');
        let descuento_ver = button.getAttribute('data-descuento');
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
        document.getElementById('precio_inicial_ver').value = formatearMoneda(valor_inicial_ver);
        document.getElementById('descuento_ver').value = parseInt(valor_descuento_ver);
        document.getElementById('precio_total_ver').value = formatearMoneda(valor_total_ver);
        document.getElementById('selected_ver').checked = descuento_ver == 1;
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
        const valor_inicial_actualizar = button.getAttribute('data-valor_inicial');
        const valor_descuento_actualizar = button.getAttribute('data-valor_descuento');
        const valor_total_actualizar = button.getAttribute('data-valor_total');
        let descuento_actualizar = button.getAttribute('data-descuento');
        let estado = 'Activo';

        if(descuento_actualizar == 1) {
            selected_actualizar.checked = true;
            input_precio_actualizar.classList.remove('oculto')
        } else {
            selected_actualizar.checked = false;
            input_precio_actualizar.classList.add('oculto');
        }

        document.getElementById('id_servicio_actualizar').value = id || '';
        document.getElementById('nombre_actualizar').value = nombre_actualizar || '';
        document.getElementById('descripcion_actualizar').value = descripcion_actualizar || '';
        modal_actualizar.querySelector('.precio_inicial').value = formatearMoneda(valor_inicial_actualizar || 0);
        modal_actualizar.querySelector('.descuento').value = parseInt(valor_descuento_actualizar);
        modal_actualizar.querySelector('.precio_total').value = formatearMoneda(valor_total_actualizar || 0);
        document.getElementById('estado_actualizar').value = estado;
    });
});

function actualizar() {

    const nombre_actualizar = document.getElementById('nombre_actualizar');
    const descripcion_actualizar = document.getElementById('descripcion_actualizar');

    const modal_actualizar = document.getElementById('exampleModalActualizar');

    const precio_inicial_actualizar = modal_actualizar.querySelector('.precio_inicial');

    const precio_total_actualizar = modal_actualizar.querySelector('.precio_total');

    const descuento_actualizar = modal_actualizar.querySelector('.descuento');

    const selected_actualizar = modal_actualizar.querySelector('.selected_actualizar');

    let indicativo_descuento = 0;

    if (!token) {
        console.error('Token CSRF no encontrado');
        alert('Error de seguridad. Por favor, recarga la página.');
        return;
    }

    // Limpiar errores antes de validar
    [nombre_actualizar, descripcion_actualizar, precio_inicial_actualizar].forEach(limpiarError);

    // Validaciones
    if (!nombre_actualizar.value.trim()) {
        marcarError(nombre_actualizar, 'El primer nombre es obligatorio');
        hayErrores = true;
    }

    if (!descripcion_actualizar.value.trim()) {
        marcarError(descripcion_actualizar, 'La descripción es obligatoria');
        hayErrores = true;
    }

    if (!precio_inicial_actualizar.value.trim()) {
        marcarError(precio_inicial_actualizar, 'Debes ingresar el precio del servicio');
        hayErrores = true;
    }

    if(selected_actualizar.checked) {
        seleccionado = 1;
    }
    else if (!selected_actualizar.checked) {
        seleccionado = 0;
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
            descripcion: descripcion_actualizar.value.trim(),
            valor_inicial: obtenerValorNumerico(precio_inicial_actualizar.value).toFixed(2),
            descuento: seleccionado,
            valor_descuento: descuento_actualizar.value !== '' ? parseFloat(descuento_actualizar.value).toFixed(2) : '0.00',
            valor_total: obtenerValorNumerico(precio_total_actualizar.value).toFixed(2)
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
                        if(seleccionado === 1) {
                            indicativo_descuento = 'Sí';
                        } else  if(seleccionado === 0){
                            indicativo_descuento = 'No';
                        }

                        if(!selected_actualizar.checked) {
                            descuento_actualizar.value = 0;
                        }
                        const fila = document.getElementById(`fila_servicio_${id}`);

                        if (fila) {
                            fila.children[0].textContent = nombre_actualizar.value.trim();
                            fila.children[1].textContent = descripcion_actualizar.value.trim();
                            fila.children[2].textContent = precio_inicial_actualizar.value;
                            fila.children[3].textContent = indicativo_descuento;
                            fila.children[4].textContent = descuento_actualizar.value +'%';
                            fila.children[5].textContent = precio_total_actualizar.value;
                        }

                        const btnEditar = fila.querySelector('[data-bs-target="#exampleModalActualizar"]');

                        if (btnEditar) {
                            btnEditar.setAttribute('data-nombre', nombre_actualizar.value.trim());
                            btnEditar.setAttribute('data-descripcion', descripcion_actualizar.value.trim());
                            btnEditar.setAttribute('data-valor_inicial', obtenerValorNumerico(precio_inicial_actualizar.value));
                            btnEditar.setAttribute('data-descuento', seleccionado);
                            btnEditar.setAttribute('data-valor_descuento', descuento_actualizar.value !== ''? parseInt(descuento_actualizar.value): 0);
                            btnEditar.setAttribute('data-valor_total', obtenerValorNumerico(precio_total_actualizar.value));
                        }

                        const btnVer = fila.querySelector('[data-bs-target="#exampleModalVer"]');

                        if (btnVer) {
                            btnVer.setAttribute('data-nombre', nombre_actualizar.value.trim());
                            btnVer.setAttribute('data-descripcion', descripcion_actualizar.value.trim());
                            btnVer.setAttribute('data-valor_inicial', obtenerValorNumerico(precio_inicial_actualizar.value));
                            btnVer.setAttribute('data-descuento', seleccionado);
                            btnVer.setAttribute('data-valor_descuento', parseInt(descuento_actualizar.value));
                            btnVer.setAttribute('data-valor_total', obtenerValorNumerico(precio_total_actualizar.value))
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

        let estadoDescuento = 0;

        if(servicio.descuento === 1) {
            estadoDescuento = 'Sí'
        } else if (servicio.descuento === 0) {
            estadoDescuento = 'No'
        }

        tabla.innerHTML += `
            <tr id="fila_servicio_${servicio.id}">
                <td>${servicio.nombre}</td>
                <td>${servicio.descripcion}</td>
                <td>${formatearMoneda(servicio.valor_inicial)}</td>
                <td>${estadoDescuento}</td>
                <td>${parseInt(servicio.valor_descuento)}%</td>
                <td>${formatearMoneda(servicio.valor_total)}</td>

                <td class="text-center align-middle">
                    ${estadoIcono}
                </td>

                <td class="text-center align-middle">

                    <a style="color: orange; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalVer"
                        data-id="${servicio.id}"
                        data-nombre="${servicio.nombre}"
                        data-descripcion="${servicio.descripcion}"
                        data-valor_inicial="${servicio.valor_inicial}"
                        data-descuento="${servicio.descuento}"
                        data-valor_descuento="${servicio.valor_descuento}"
                        data-valor_total="${servicio.valor_total}"
                        data-estado="1">
                        <i class="bx bx-show"></i>
                    </a>

                    <a style="color: purple; cursor: pointer;"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModalActualizar"
                        data-id="${servicio.id}"
                        data-nombre="${servicio.nombre}"
                        data-descripcion="${servicio.descripcion}"
                        data-valor_inicial="${servicio.valor_inicial}"
                        data-descuento="${servicio.descuento}"
                        data-valor_descuento="${servicio.valor_descuento}"
                        data-valor_total="${servicio.valor_total}"
                        data-estado="1">
                        <i class="bx bx-edit"></i>
                    </a>

                    <a style="color: red; cursor: pointer;"
                        data-id="${servicio.id}"
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
// Formatear un número como moneda COP
function formatearMoneda(valor) {

    // Convertir el valor a número
    let numero = Number(valor);

    // Evitar NaN
    if (!Number.isFinite(numero)) {
        return '';
    }

    // Redondear para evitar problemas de precisión decimal
    numero = Math.round(numero);

    return new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(numero);
}

// Obtener el valor numérico de un precio formateado
function obtenerValorNumerico(valor) {

    if (valor === null || valor === undefined || valor === '') {
        return 0;
    }

    // Convertir a texto
    let texto = valor.toString();

    // Dejar únicamente los números
    let numero = texto.replace(/[^\d]/g, '');

    // Si no existen números
    if (numero === '') {
        return 0;
    }

    numero = Number(numero);

    // Evitar NaN
    if (!Number.isFinite(numero)) {
        return 0;
    }

    return numero;
}
// Calcular el precio con el descuento para el precio total
document.addEventListener('DOMContentLoaded', function () {

    function calcularPrecioTotal() {

        // Obtener los elementos del modal actualizar
        const modal_actualizar = document.getElementById('exampleModalActualizar');

        // Elementos de actualizar
        const precio_inicial_actualizar = modal_actualizar ? modal_actualizar.querySelector('.precio_inicial'): null;

        const precio_total_actualizar = modal_actualizar ? modal_actualizar.querySelector('.precio_total') : null;

        const descuento_actualizar = modal_actualizar ? modal_actualizar.querySelector('.descuento') : null;

        const selected_actualizar_element = modal_actualizar ? modal_actualizar.querySelector('.selected_actualizar') : null;

        /*
         * Si estamos trabajando con el modal actualizar,
         * utilizamos sus propios campos.
         */
        
        if (modal_actualizar && precio_inicial_actualizar && precio_total_actualizar && descuento_actualizar && selected_actualizar_element) {

            let precio_valor = obtenerValorNumerico(precio_inicial_actualizar.value);

            if (selected_actualizar_element.checked) {

                let descuento_valor = Number(descuento_actualizar.value) || 0;

                // Calcular valor del descuento
                let valor_descuento = precio_valor * (descuento_valor / 100);

                // Calcular precio final
                let precio_final = precio_valor - valor_descuento;

                // Mostrar precio total formateado
                precio_total_actualizar.value = formatearMoneda(precio_final);

            } else {
                // Sin descuento
                precio_total_actualizar.value = formatearMoneda(precio_valor);
            }
        }

        /*
         * Mantener la lógica existente del formulario crear.
         */
        
        if (typeof precio_inicial !== 'undefined' && typeof precio_total !== 'undefined' && typeof selected !== 'undefined' && typeof descuento !== 'undefined') {

            let precio_valor = obtenerValorNumerico(precio_inicial.value);

            if (selected.checked) {

                let descuento_valor = Number(descuento.value) || 0;

                let valor_descuento = precio_valor * (descuento_valor / 100);

                let precio_final = precio_valor - valor_descuento;

                precio_total.value = formatearMoneda(precio_final);

            } else {

                precio_total.value = formatearMoneda(precio_valor);
            }
        }
    }

    /*
     * FORMULARIO CREAR
     */
    
    if (typeof precio_inicial !== 'undefined' && precio_inicial) {

        precio_inicial.addEventListener('input', function () {

            let valor = obtenerValorNumerico(this.value);

            this.value = formatearMoneda(valor);

            calcularPrecioTotal();
        });
    }

    /*
     * CHECKBOX CREAR
     */
    
    if (typeof selected !== 'undefined' && selected) {

        selected.addEventListener('change', function () {

            if (this.checked) {

                input_precio.classList.remove('oculto');

                calcularPrecioTotal();

            } else {

                input_precio.classList.add('oculto');

                descuento.value = '';

                calcularPrecioTotal();
            }
        });
    }

    if (typeof descuento !== 'undefined' && descuento) {

        descuento.addEventListener('input', function () {
            calcularPrecioTotal();
        });
    }

    /*
     * PRECIO INICIAL DEL MODAL ACTUALIZAR
    */
    
    const modal_actualizar = document.getElementById('exampleModalActualizar');

    if (modal_actualizar) {

        const precio_inicial_actualizar = modal_actualizar.querySelector('.precio_inicial');

        const precio_total_actualizar = modal_actualizar.querySelector('.precio_total');

        const descuento_actualizar = modal_actualizar.querySelector('.descuento');

        const selected_actualizar_element = modal_actualizar.querySelector('.selected_actualizar');

        const input_precio_actualizar = modal_actualizar.querySelector('.input_precio_actualizar');

        /*
         * Cuando cambia el precio inicial del modal actualizar
         */
        
        if (precio_inicial_actualizar) {

            precio_inicial_actualizar.addEventListener('input',function () {

                    let valor = obtenerValorNumerico(this.value);
                    this.value = formatearMoneda(valor);
                    calcularPrecioTotal();
                }
            );
        }

        /*
         * Checkbox actualizar
         */
        
        if (selected_actualizar_element) {

            selected_actualizar_element.addEventListener('change',function () {

                    if (this.checked) {
                        input_precio_actualizar.classList.remove('oculto');
                        descuento_actualizar.value = 0;
                        calcularPrecioTotal();
                    } else {
                        input_precio_actualizar.classList.add('oculto');
                        calcularPrecioTotal();
                    }
                }
            );
        }

        /*
         * Cuando cambia el descuento del modal actualizar
         */
        if (descuento_actualizar) {

            descuento_actualizar.addEventListener('input',function () {
                    calcularPrecioTotal();
                }
            );
        }
    }

    /*
     * Formatear precio inicial si ya tiene un valor
     */
    if (typeof precio_inicial !== 'undefined' && precio_inicial && precio_inicial.value.trim() !== '') {

        let valor_inicial = obtenerValorNumerico(precio_inicial.value);

        precio_inicial.value = formatearMoneda(valor_inicial);
    }

    /*
     * Calcular precio total inicialmente
     */
    calcularPrecioTotal();
});