@extends('layouts.app')

@section('content')

<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
        <a class="navbar-brand" href="#page-top"><img class= "logo-navbar" src="{{ asset('img/reservali-logo.png') }}" alt="..."/></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
            aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu
            <i class="fas fa-bars ms-1"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                <!--<li class="nav-item"><a class="nav-link" href="#services">Nuestros servicios</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="#about">Contáctanos</a></li>-->
                <!--<li class="nav-item"><a class="nav-link" href="#team">Equipo de trabajo</a></li>-->
                <li class="nav-item"><a class="nav-link" href="{{ route('auth.auths') }}">Ingrese aquí</a></li>
            </ul>
        </div>
    </div>
</nav>

<!-- Masthead-->
<header class="masthead">
    <div class="container">
        <div class="masthead-subheading">Bienvenido a nuestro sistema de agendamiento y reservación de citas "Reservali".</div>
        <!--<div class="masthead-heading text-uppercase">El Sistema útil para la organización de tu negocio </div>-->
        <a class="btn btn-primary btn-xl text-uppercase" href="#services">Nuestros servicios</a>
    </div>
</header>

<!-- Services-->
<section class="page-section" id="services">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Dirigido para</h2>
            <h3 class="section-subheading text-muted">Nustro sistema pensado especialmente para negocios u organizaciones dedicadas al uso del reservaciones.</h3>
        </div>
        <div class="row text-center">
            <div class="col-md-6">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa-solid fa-spa fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Spa</h4>
                <p class="text-muted"></p>
            </div>
            <div class="col-md-6">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fa-solid fa-scissors fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Barberías</h4>
                <p class="text-muted"></p>
            </div>
            <!--<div class="col-md-4">
                <span class="fa-stack fa-4x">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-lock fa-stack-1x fa-inverse"></i>
                </span>
                <h4 class="my-3">Web Security</h4>
                <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Minima maxime quam architecto quo inventore harum ex magni, dicta impedit.</p>
            </div>-->
        </div>
    </div>
</section>

<!-- Portfolio Grid-->
<!--<section class="page-section bg-light" id="portfolio">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Portfolio</h2>
            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
        <div class="row">
            @for ($i = 1; $i <= 6; $i++)
                <div class="col-lg-4 col-sm-6 mb-4">
                    <div class="portfolio-item">
                        <a class="portfolio-link" data-bs-toggle="modal" href="#portfolioModal{{ $i }}">
                            <div class="portfolio-hover">
                                <div class="portfolio-hover-content"><i class="fas fa-plus fa-3x"></i></div>
                            </div>
                            <img class="img-fluid" src="{{ asset('img/portfolio/'.$i.'.jpg') }}" alt="..." />
                        </a>
                        <div class="portfolio-caption">
                            <div class="portfolio-caption-heading">Project {{ $i }}</div>
                            <div class="portfolio-caption-subheading text-muted">Category</div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>-->

<!-- About-->
<!--<section class="page-section" id="about">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">About</h2>
            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
        <ul class="timeline">
            @for ($i = 1; $i <= 4; $i++)
                <li class="{{ $i % 2 == 0 ? 'timeline-inverted' : '' }}">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="{{ asset('img/about/'.$i.'.jpg') }}" alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>Year {{ 2008 + $i }}</h4>
                            <h4 class="subheading">Event {{ $i }}</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut voluptatum eius sapiente.</p>
                        </div>
                    </div>
                </li>
            @endfor
            <li class="timeline-inverted">
                <div class="timeline-image">
                    <h4>
                        Be Part
                        <br />Of Our<br />Story!
                    </h4>
                </div>
            </li>
        </ul>
    </div>
</section>-->

<!-- Team-->
<!--<section class="page-section bg-light" id="team">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Our Amazing Team</h2>
            <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
        </div>
        <div class="row">
            @for ($i = 1; $i <= 3; $i++)
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="{{ asset('img/team/'.$i.'.jpg') }}" alt="..." />
                        <h4>Member {{ $i }}</h4>
                        <p class="text-muted">Role {{ $i }}</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            @endfor
        </div>
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque, laboriosam veritatis, quos non quis ad perspiciatis.</p>
            </div>
        </div>
    </div>
</section>-->

<!-- Clients-->
<!--<div class="py-5">
    <div class="container">
        <div class="row align-items-center">
            @foreach (['microsoft', 'google', 'facebook', 'ibm'] as $logo)
                <div class="col-md-3 col-sm-6 my-3">
                    <a href="#!"><img class="img-fluid img-brand d-block mx-auto" src="{{ asset('img/logos/'.$logo.'.svg') }}" alt="{{ $logo }}" /></a>
                </div>
            @endforeach
        </div>
    </div>
</div>-->

<!-- Contact-->
<!--<section class="page-section" id="contact">
    <div class="container">
        <div class="text-center">
            <h2 class="section-heading text-uppercase">Comunícate con nosotros</h2>
            <h3 class="section-subheading text-muted">Por medio de este formulario podrás contactarte con nosotros</h3>
        </div>
        <form id="contactForm" data-sb-form-api-token="API_TOKEN">
            <div class="row align-items-stretch mb-5">
                <div class="col-md-6">
                    <input class="form-control mb-3" id="name" type="text" placeholder="Your Name *" data-sb-validations="required" />
                    <input class="form-control mb-3" id="email" type="email" placeholder="Your Email *" data-sb-validations="required,email" />
                    <input class="form-control mb-3" id="phone" type="tel" placeholder="Your Phone *" data-sb-validations="required" />
                </div>
                <div class="col-md-6">
                    <textarea class="form-control" id="message" placeholder="Your Message *" data-sb-validations="required"></textarea>
                </div>
            </div>
            <div class="text-center">
                <button class="btn btn-primary btn-xl text-uppercase disabled" id="submitButton" type="submit">Enviar Mensaje</button>
            </div>
        </form>
    </div>
</section>-->

<!-- Footer-->
<footer class="footer py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4 text-lg-start">Copyright &copy; Sistema de agendamientos 2025</div>
            <div class="col-lg-4 my-3 my-lg-0">
                <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-twitter"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-facebook-f"></i></a>
                <a class="btn btn-dark btn-social mx-2" href="#!"><i class="fab fa-linkedin-in"></i></a>
            </div>
            <div class="col-lg-4 text-lg-end">
                <!--<a class="link-dark text-decoration-none me-3" href="#!">Privacy Policy</a>
                <a class="link-dark text-decoration-none" href="#!">Terms of Use</a>-->
            </div>
        </div>
    </div>
</footer>

@endsection