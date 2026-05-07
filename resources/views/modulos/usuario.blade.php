@extends('layouts.panel')

@section('content')

{{-- LISTAR USUARIO--}}
<div class="card mt-4 p-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0">Usuarios Activos</h6>

        <div class="d-flex align-items-center gap-2">

            <!-- BOTONES -->
            <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Agregar
            </button>

            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModalRestaurar">
                Restaurar
            </button>

            <!-- BUSCADOR -->
            <div class="position-relative" style="width: 180px;">
                <i class='bx bx-search position-absolute'
                    style="top: 50%; left: 10px; transform: translateY(-50%); color: gray;"></i>

                <input
                    type="text"
                    id="input_buscar"
                    class="form-control ps-5"
                    placeholder="Buscar...">
            </div>

        </div>
    </div>
    <table class="table align-middle">
        <thead>
            <tr>
                <!--<th>#</th>-->
                <th>Número identificación</th>
                <th>Nombre completo</th>
                <th>Email</th>
                <th>Teléfono</th>
                <th class="text-center align-middle">Estado</th>
                <th class="text-center align-middle">Acciones</th>
            </tr>
        </thead>
        <tbody id="tabla_usuarios">
            @foreach($usuarios as $usuario)
            <tr id="fila_usuario_{{ $usuario['id'] }}">
                <!--<td>{{ $usuario['id'] }}</td>-->
                <td>{{ $usuario['num_identificacion'] }}</td>
                <td>{{ $usuario['name'] }}</td>
                <td>{{ $usuario['email'] }}</td>
                <td>{{ $usuario['telefono'] }}</td>
                @if ($usuario['estado'] === 1 )
                <td class="text-center align-middle"><i class="bx bx-check-circle" style="color:green;"></i></td>
                @endif
                <td class="text-center align-middle">
                    <a style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModalVer" data-id="{{ $usuario['id'] }}" data-nombre="{{ $usuario['name'] }}" data-email="{{ $usuario['email'] }}" data-estado="{{ $usuario['estado'] }}" data-num_identificacion="{{ $usuario['num_identificacion'] }}" data-direccion="{{ $usuario['direccion'] }}" data-telefono="{{ $usuario['telefono'] }}" data-tipo_identificacion="{{ $usuario->tipoDocumento->cod_tipo_documento }} - {{ $usuario->tipoDocumento->nom_tipo_documento }}" data-genero="{{ $usuario->genero->nom_genero }}"><i class="bx bx-show"></i></a>
                    <a style="color: purple; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModalActualizar" data-id="{{ $usuario['id'] }}" data-nombre="{{ $usuario['name'] }}" data-email="{{ $usuario['email'] }}" data-estado="{{ $usuario['estado'] }}" data-num_identificacion="{{ $usuario['num_identificacion'] }}" data-direccion="{{ $usuario['direccion'] }}" data-telefono="{{ $usuario['telefono'] }}" data-tipo_identificacion="{{ $usuario['id_tipo_documento'] }}" data-genero="{{ $usuario['id_genero'] }}"><i class="bx bx-edit"></i></a>
                    <a style="color: red; cursor: pointer;" data-id="{{ $usuario['id'] }}" onclick="eliminar_usuario(this)"><i class="bx bx-trash"></i></a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="position-relative mt-3">
        <div class="d-flex justify-content-center">
            <select id="select_por_pagina" class="form-select" style="width:100px;">
                <option value="5">5</option>
                <option value="10" selected>10</option>
                <option value="20">20</option>
            </select>
        </div>

        <div id="paginacion"
            class="position-absolute top-50 end-0 translate-middle-y">
        </div>
    </div>
</div>

{{-- Modal--}}
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Agregar usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_create">
                    @csrf

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="tipo_identificacion_label mb-2">Tipo De Identificación <span style="color:red;">*</span></label>
                            <select id="tipo_identificacion" name="tipo_identificacion" class="form-control" required>
                                <option selected>seleccione</option>
                                @foreach ($tipo_documentos as $tipo_documento)
                                <option value="{{ $tipo_documento->id }}">
                                    {{ $tipo_documento->cod_tipo_documento }} - {{ $tipo_documento->nom_tipo_documento }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_identificacion_label mb-2">Número De Identificación <span style="color:red;">*</span></label>
                            <input type="text" id="num_identificacion" name="num_identificacion" class="form-control" placeholder="Segundo nombre del usuario">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="primer_nombre_label mb-2">Primer Nombre <span style="color:red;">*</span> </label>
                            <input type="text" id="primer_nombre" name="primer_nombre" class="form-control" placeholder="Primer nombre del usuario" required>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_nombre_label mb-2">Segundo Nombre</label>
                            <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control" placeholder="Segundo nombre del usuario">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6 mb-2">
                            <label for="primer_apellido_label">Primer Apellido <span style="color:red;">*</span> </label>
                            <input type="text" id="primer_apellido" name="primer_apellido" class="form-control" placeholder="Primer apellido del usuario" required>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_apellido_label mb-2">Segundo Apellido</label>
                            <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" placeholder="Segundo apellido del usuario">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="genero_label mb-2">Género <span style="color:red;">*</span></label>
                            <select id="genero" name="genero" class="form-control" required>
                                <option selected>seleccione</option>
                                @foreach ($generos as $genero)
                                <option value="{{ $genero->id }}">
                                    {{ $genero->nom_genero }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="email_label mb-2">Correo electrónico <span style="color:red;">*</span> </label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="direccion_label mb-2">Dirección <span style="color:red;">*</span> </label>
                            <input type="text" id="direccion" name="direccion" class="form-control" placeholder="Dirección" required>
                        </div>

                        <div class="col-md-6">
                            <label for="telefono_label mb-2">Teléfono <span style="color:red;">*</span> </label>
                            <input type="text" id="telefono" name="telefono" class="form-control" placeholder="Teléfono" required>
                        </div>
                    </div>

                    <div class="col-md-4" hidden>
                        <label for="password_label mb-2">Contraseña <span style="color:red;">*</span> </label>
                        <input type="password" id="password" name="password" class="form-control" value="12345678" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i> Cancelar</button>
                <button type="button" id="btn_save_create" name="btn_save_create" class="btn btn-primary" onclick="guardar_crear()"><i class="bx bx-save"></i> Guardar y crear</button>
                <button type="button" id="btn_save" name="btn_save" class="btn btn-primary" onclick="guardar()"><i class="bx bx-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Ver --}}
<div class="modal fade" id="exampleModalVer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ver información</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form_create">

                    <div class="row g-3 mb-3">
                        <input type="text" id="id_user_ver" name="id_user_ver" disabled hidden>
                        <div class="col-md-6">
                            <label for="tipo_identificacion_label mb-2">Tipo Identificación</label>
                            <input type="text" id="tipo_identificacion_ver" name="tipo_identificacion_ver" class="form-control" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_identificacion_label mb-2">Número De Identificación</label>
                            <input type="text" id="numero_identificacion_ver" name="numero_identificacion_ver" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="primer_nombre_label mb-2">Primer Nombre</label>
                            <input type="text" id="primer_nombre_ver" name="primer_nombre_ver" class="form-control" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_nombre_label mb-2">Segundo Nombre</label>
                            <input type="text" id="segundo_nombre_ver" name="segundo_nombre_ver" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6 mb-2">
                            <label for="primer_apellido_label">Primer Apellido</label>
                            <input type="text" id="primer_apellido_ver" name="primer_apellido_ver" class="form-control" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_apellido_label mb-2">Segundo Apellido</label>
                            <input type="text" id="segundo_apellido_ver" name="segundo_apellido_ver" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="genero_label mb-2">Género</label>
                            <input type="text" id="genero_ver" name="genero_ver" class="form-control" disabled>
                        </div>

                        <div class="col-md-6">
                            <label for="email_label mb-2">Correo electrónico</label>
                            <input type="email" id="email_ver" name="email_ver" class="form-control" disabled>
                        </div>

                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-4">
                            <label for="direccion_label mb-2">Dirección</label>
                            <input type="email" id="direccion_ver" name="direccion_ver" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label for="telefono_label mb-2">Teléfono</label>
                            <input type="email" id="telefono_ver" name="telefono_ver" class="form-control" disabled>
                        </div>

                        <div class="col-md-4">
                            <label for="estado_label mb-2">Estado</label>
                            <input type="text" id="estado_ver" name="estado_ver" class="form-control" disabled>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <!--<button type="button" class="btn btn-secondary me-2" data-bs-toggle="modal" data-bs-target="#exampleModalRestaurar"><i class="bx bx-arrow-from-right fs-2"></i> Regresar</button>-->
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Actualizar --}}
<div class="modal fade" id="exampleModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="form_create">
                    @csrf

                    <div class="row g-3 mb-3">
                        <input type="hidden" id="id_user_actualizar" name="id_user_actualizar">
                        <div class="col-md-6">
                            <label for="tipo_identificacion_label mb-2">Tipo De Identificación <span style="color:red;">*</span></label>
                            <select id="tipo_identificacion_actualizar" name="tipo_identificacion_actualizar" class="form-control" required>
                                <option selected>seleccione</option>
                                @foreach ($tipo_documentos as $tipo_documento)
                                <option value="{{ $tipo_documento->id }}">
                                    {{ $tipo_documento->cod_tipo_documento }} - {{ $tipo_documento->nom_tipo_documento }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="numero_identificacion_label mb-2">Número De Identificación</label>
                            <input type="text" id="numero_identificacion_actualizar" name="numero_identificacion_actualizar" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="primer_nombre_label mb-2">Primer Nombre <span style="color:red;">*</span> </label>
                            <input type="text" id="primer_nombre_actualizar" name="primer_nombre_actualizar" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_nombre_label mb-2">Segundo Nombre</label>
                            <input type="text" id="segundo_nombre_actualizar" name="segundo_nombre_actualizar" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6 mb-2">
                            <label for="primer_apellido_label">Primer Apellido <span style="color:red;">*</span> </label>
                            <input type="text" id="primer_apellido_actualizar" name="primer_apellido_actualizar" class="form-control" required>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_apellido_label mb-2">Segundo Apellido</label>
                            <input type="text" id="segundo_apellido_actualizar" name="segundo_apellido_actualizar" class="form-control">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="genero_label mb-2">Género <span style="color:red;">*</span></label>
                            <select id="genero_actualizar" name="genero_actualizar" class="form-control" required>
                                <option selected>seleccione</option>
                                @foreach ($generos as $genero)
                                <option value="{{ $genero->id }}">
                                    {{ $genero->nom_genero }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="email_label mb-2">Correo electrónico <span style="color:red;">*</span> </label>
                            <input type="email" id="email_actualizar" name="email_actualizar" class="form-control" required>
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="direccion_label mb-2">Dirección <span style="color:red;">*</span> </label>
                            <input type="text" id="direccion_actualizar" name="direccion_actualizar" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="telefono_label mb-2">Teléfono <span style="color:red;">*</span> </label>
                            <input type="text" id="telefono_actualizar" name="telefono_actualizar" class="form-control" required>
                        </div>
                        <div class="col-md-2" hidden>
                            <label for="estado_label mb-2">Estado</label>
                            <input type="text" id="estado_actualizar" name="estado_actualizar" class="form-control" disabled>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i> Cancelar</button>
                <button type="button" id="btn_save" name="btn_save" class="btn btn-primary" onclick="actualizar()"><i class="bx bx-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Restaurar  --}}
<div class="modal fade" id="exampleModalRestaurar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Restaurar usuarios</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nombre completo</th>
                            <th>Email</th>
                            <th class="text-center align-middle">Estado</th>
                            <th class="text-center align-middle">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_usuarios_inactivos">
                        @foreach($usuarios_inactivos as $usuario_inactivo)
                        <tr id="fila_usuario_inactivo_{{ $usuario_inactivo['id'] }}">
                            <!--<td>{{ $usuario_inactivo['id'] }}</td>-->
                            <td>{{ $usuario_inactivo['name'] }}</td>
                            <td>{{ $usuario_inactivo['email'] }}</td>
                            @if ($usuario_inactivo['estado'] === 0 )
                            <td class="text-center align-middle"><i class="bx bx-x-circle" style="color:red;"></i></td>
                            @endif
                            <td class="text-center align-middle">
                                <a style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModalVer" data-id="{{ $usuario_inactivo['id'] }}" data-nombre="{{ $usuario_inactivo['name'] }}" data-email="{{ $usuario_inactivo['email'] }}" data-estado="{{ $usuario_inactivo['estado'] }}"><i class="bx bx-show"></i></a>
                                <a style="color: gold; cursor: pointer;align-items: center;" data-id="{{ $usuario_inactivo['id'] }}" onclick="restaurar_usuario(this)"><i class="bx bx-refresh"></i></a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i> Cancelar</button>
            </div>
        </div>
    </div>
</div>
@endsection