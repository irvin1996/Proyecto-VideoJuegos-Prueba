<nav class="navbar navbar-expand-lg bg-dark">
  <a class="navbar-brand" href="{{ route('vj.index')}}">VideoJuegos</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="{{route('vj.index')}}">Listado de VideoJuegos</a>
      </li>
      @auth
      <li class="nav-item active">
        <a class="nav-link" href="{{route('admin.index')}}">Gestion de Video Juegos</a>
      </li>
      <li class="nav-item">
  <a class="nav-link" href="{{ route('admin.grafico') }}">Gráficos Videojuegos</a>
</li>
<li class="nav-item">
  <a class="nav-link" href="{{ route('plataforma.index') }}">Gestión de Plataformas</a>
</li>
@endauth
      <li class="nav-item">
        <a class="nav-link" href="{{ route('otros.acerca')}}">Acerca de</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <!-- Authentication Links -->
        @guest
            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
        @else
            <li class="nav-item dropdown">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                    {{ Auth::user()->name }} <span class="caret"></span>
                </a>

                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
  </div>
</nav>
