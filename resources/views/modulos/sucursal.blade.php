@extends('layouts.panel')

@section('content')

    {{-- LISTAR USUARIO--}}
    <div class="card mt-4 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h6 class="mb-0">Sucursales</h6>

            <div class="d-flex align-items-center gap-2">

                <!-- BOTONES -->
                <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Agregar
                </button>

                <!-- BUSCADOR -->
                <div class="position-relative" style="width: 180px;">
                    <i class='bx bx-search position-absolute'
                        style="top: 50%; left: 10px; transform: translateY(-50%); color: gray;"></i>

                    <input type="text" id="input_buscar" class="form-control ps-5" placeholder="Buscar...">
                </div>

            </div>
        </div>
        <table class="table align-middle">
            <thead>
                <tr>
                    <!--<th>#</th>-->
                    <th>Nombre de la sucursal</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th class="text-center align-middle">Estado</th>
                    <th class="text-center align-middle">Acciones</th>
                </tr>
            </thead>
            <tbody id="tabla_sucursales">
                @foreach($sucursales as $sucursal)
                    <tr id="fila_sucursal_{{ $sucursal['id'] }}">
                        
                        <td>{{ $sucursal['nombre'] }}</td>
                        <td>{{ $sucursal['direccion'] }}</td>
                        <td>{{ $sucursal['telefono'] }}</td>
                        @if ($sucursal['estado'] === 1)
                            <td class="text-center align-middle"><i class="bx bx-check-circle" style="color:green;"></i></td>
                        @endif
                        <td class="text-center align-middle">

                            agregar
                            <!--<a style="color: orange; cursor: pointer;" data-bs-toggle="modal" data-bs-target="#exampleModalVer"
                                data-id="{{ $usuario['id'] }}" data-nombre="{{ $usuario['name'] }}"
                                data-email="{{ $usuario['email'] }}" data-estado="{{ $usuario['estado'] }}"
                                data-num_identificacion="{{ $usuario['num_identificacion'] }}"
                                data-direccion="{{ $usuario['direccion'] }}" data-telefono="{{ $usuario['telefono'] }}"
                                data-tipo_identificacion="{{ $usuario->tipoDocumento->cod_tipo_documento }} - {{ $usuario->tipoDocumento->nom_tipo_documento }}"
                                data-genero="{{ $usuario->genero->nom_genero }}"><i class="bx bx-show"></i></a>
                            <a style="color: purple; cursor: pointer;" data-bs-toggle="modal"
                                data-bs-target="#exampleModalActualizar" data-id="{{ $usuario['id'] }}"
                                data-nombre="{{ $usuario['name'] }}" data-email="{{ $usuario['email'] }}"
                                data-estado="{{ $usuario['estado'] }}"
                                data-num_identificacion="{{ $usuario['num_identificacion'] }}"
                                data-direccion="{{ $usuario['direccion'] }}" data-telefono="{{ $usuario['telefono'] }}"
                                data-tipo_identificacion="{{ $usuario['id_tipo_documento'] }}"
                                data-genero="{{ $usuario['id_genero'] }}"><i class="bx bx-edit"></i></a>
                            <a style="color: red; cursor: pointer;" data-id="{{ $usuario['id'] }}"
                                onclick="eliminar_usuario(this)"><i class="bx bx-trash"></i></a>-->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="position-relative mt-3">
            <div class="d-flex justify-content-center">
                <select id="select_por_pagina" class="form-select" style="width:100px;">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                </select>
            </div>

            <div id="paginacion" class="position-absolute top-50 end-0 translate-middle-y">
            </div>
        </div>
    </div>

    {{-- Modal--}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Agregar sucursales</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form_create">
                        @csrf
                        <div class="row g-4 mb-4">
                            <div class="col-md-4">
                                <label for="nombre_sucursal_label mb-2">Nombre sucursal <span
                                        style="color:red;">*</span></label>
                                <input type="text" id="nombre" name="nombre" class="form-control"
                                    placeholder="Ingrese el nombre de la sucursal" required>
                            </div>

                            <div class="col-md-4">
                                <label for="direccion_label mb-2">Dirección <span style="color:red;">*</span>
                                </label>
                                <input type="text" id="direccion" name="direccion" class="form-control"
                                    placeholder="Ingrese la dirección de la sucursal" required>
                            </div>

                            <div class="col-md-4">
                                <label for="segundo_nombre_label mb-2">Teléfono <span style="color:red;">*</span></label>
                                <input type="text" id="telefono" name="telefono" class="form-control"
                                    placeholder="Ingrese el número de teléfono">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i>
                        Cancelar</button>
                    <button type="button" id="btn_save_create" name="btn_save_create" class="btn btn-primary"
                        onclick="guardar_crear()"><i class="bx bx-save"></i> Guardar y crear</button>
                    <button type="button" id="btn_save" name="btn_save" class="btn btn-primary" onclick="guardar_sucursal()"><i
                            class="bx bx-save"></i> Guardar</button>
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
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="nombre_sucursal_label mb-2">Nombre sucursal </label>
                                <input type="text" id="nombre_ver" name="nombre" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label for="direccion_label mb-2">Dirección </label>
                                <input type="text" id="direccion_ver" name="direccion" class="form-control" required>
                            </div>

                            <div class="col-md-4">
                                <label for="telefono_label mb-2">Teléfono </label>
                                <input type="text" id="telefono_ver" name="telefono_ver" class="form-control">
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
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i>
                        Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Actualizar --}}
    <div class="modal fade" id="exampleModalActualizar" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar sucursales</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="form_create">
                        @csrf

                        <div class="row g-3 mb-3">
                            <input type="hidden" id="id_user_actualizar" name="id_user_actualizar">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-2" hidden>
                                <label for="estado_label mb-2">Estado</label>
                                <input type="text" id="estado_actualizar" name="estado_actualizar" class="form-control"
                                    disabled>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i>
                        Cancelar</button>
                    <button type="button" id="btn_save" name="btn_save" class="btn btn-primary" onclick="actualizar()"><i
                            class="bx bx-save"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/module_sucursales.js') }}"></script>
@endpush