<div class="main-navigation" id="mainmenu-area">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary main-nav navbar-togglable rounded-radius">

                <a class="navbar-brand d-lg-none d-block" href="">
                    <h4>@yield('page') Page</h4>
                </a>
                <!-- Toggler -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="fa fa-bars"></span>
                </button>

                <!-- Collapse -->
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <!-- Links -->
                    <ul class="navbar-nav ">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarWelcome" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Home
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarWelcome">
                                 <a class="dropdown-item " href="{{URL::to('home')}}">
                                    Home
                                </a>
                                {{-- <a class="dropdown-item " href="index-2.html">
                                    Home-2
                                </a>
                                <a class="dropdown-item " href="index-3.html">
                                    Home-3
                                </a>
                                <a class="dropdown-item " href="index-4.html">
                                    Home-4
                                </a> --}}
                            </div>
                        </li>
                        @can('view models')
                            <li class="nav-item ">
                                <a href="{{route('post.index')}}" class="nav-link js-scroll-trigger">
                                    Posts
                                </a>
                            </li>
                        @endcan
                        <li class="nav-item ">
                            <a href="{{route('about')}}" class="nav-link js-scroll-trigger">
                                About
                            </a>
                        </li>
                        {{-- <li class="nav-item ">
                            <a href="pricing.html" class="nav-link js-scroll-trigger">
                                Pricing
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="project.html" class="nav-link js-scroll-trigger">
                                Projects
                            </a>
                        </li> --}}

                        {{-- <li class="nav-item ">
                            <a href="contact.html" class="nav-link">
                                Contact
                            </a>
                        </li> --}}
                    </ul>

                    <ul class="ml-lg-auto list-unstyled m-0">
                        <li><a href="#" class="btn btn-white btn-circled">Contact Us</a></li>
                    </ul>
                </div> <!-- / .navbar-collapse -->
            </nav>
        </div> <!-- / .container -->
    </div>
