@extends('layouts.auth')

@section('content')
<div class="container" id="container">
    <div class="form-container sign-up">
        <form method="POST">
            <h1>Registrarse aquí</h1>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
            <!--<span>Crea tu cuenta aquí</span>-->
            <input type="text" id="name" class="form-control" placeholder="Ingrese su nombre completo">
            <input type="email" id="email" class="form-control" placeholder="Ingrese el correo electrónico">
            <input type="password" id="password" class="form-control" placeholder="Ingrese el correo electrónico">
            <button type="submit">Registrarse</button>
        </form>
    </div>


    <div class="form-container sign-in">
        <form method="POST">
            <h1>Iniciar sesión aquí</h1>
            <div class="social-icons">
                <a href="#" class="icon"><i class="fa-brands fa-google-plus-g"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
            </div>
            <!--<span>Iniciar sesión aquí</span>-->
            <input type="email" id="email" class="form-control" placeholder="Ingrese el correo electrónico">
            <input type="password" id="password" class="form-control" placeholder="Ingrese el correo electrónico">
            <a href="#">Forget Your Password?</a>
            <button type="submit">Iniciar sesión</button>
        </form>
    </div>

    
    <div class="toggle-container">
        <div class="toggle">
            <div class="toggle-panel toggle-left">
                <h1>¡Hola, muchas gracias por confiar en nuestros servicios amigo!</h1>
                <p>Introduzca sus datos personales para utilizar todas las funciones del sitio</p>
                <button class="hidden" id="login">Inicia sesión aquí</button>
            </div>
            <div class="toggle-panel toggle-right">
                <h1>¡Te damos la bienvenida! </h1>
                <p>¿Es tu primera vez visitándonos? Ingresa aquí para registrarte y así tener acceso a todo nuestro mundo</p>
                <button class="hidden" id="register">Regístrate aquí</button>
            </div>
        </div>
    </div>
</div>
@endsection