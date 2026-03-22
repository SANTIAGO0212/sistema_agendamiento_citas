@extends('layouts.panel')

@section('content')

{{-- LISTAR USUARIO--}}
<div class="card mt-4 p-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h6 class="mb-0">Usuarios</h6>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">Agregar</button>
    </div>
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Nombre completo</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuarios as $usuario)
            <tr>
                <td>{{ $usuario['name'] }}</td>
                <td>{{ $usuario['email'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
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
                <form method="post">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="primer_nombre_label mb-2">Primer Nombre</label>
                            <input type="text" id="primer_nombre" name="primer_nombre" class="form-control" placeholder="Primer nombre del usuario" required>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_nombre_label mb-2">Segundo Nombre</label>
                            <input type="text" id="segundo_nombre" name="segundo_nombre" class="form-control" placeholder="Segundo nombre del usuario">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6 mb-2">
                            <label for="primer_apellido_label">Primer Apellido</label>
                            <input type="text" id="primer_apellido" name="primer_apellido" class="form-control" placeholder="Primer apellido del usuario" required>
                        </div>

                        <div class="col-md-6">
                            <label for="segundo_apellido_label mb-2">Segundo Apellido</label>
                            <input type="text" id="segundo_apellido" name="segundo_apellido" class="form-control" placeholder="Segundo del usuario">
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="email_label mb-2">Correo electrónico</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Correo electrónico" required>
                        </div>

                        <div class="col-md-4" hidden>
                            <label for="password_label mb-2">Contraseña</label>
                            <input type="password" id="password" name="password" class="form-control" value="12345678" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="bx bx-x-circle"></i> Cancelar</button>
                <button type="button" class="btn btn-primary"><i class="bx bx-save"></i> Guardar y crear</button>
                <button type="button" class="btn btn-primary"><i class="bx bx-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>
@endsection