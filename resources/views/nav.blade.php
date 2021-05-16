<nav class="navbar navbar-expand-md navbar-dark bg-info mb-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Top</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
      aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
      <ul class="navbar-nav me-auto mb-2 mb-md-0">
        <form class="d-flex">
          <input class="form-control me-2" type="search" placeholder="検索" aria-label="Search">
          <button class="btn btn-dark" type="submit">Search</button>
        </form>
    </div>
  </div>
  <!-- Dropdown -->
  <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
    aria-expanded="false">
    <i class="fas fa-user-circle">
      {{ Auth::user() ? Auth::user()->name:"ゲスト" }}
    </i>
  </a>
  <div class="dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
    {{-- ゲストのナビゲーション --}}
    @guest
    <button class="dropdown-item" type="button" onclick="location.href='{{route('login')}}'">
      ログイン
    </button>
    <div class="dropdown-divider"></div>
    <button class="dropdown-item" type="button" onclick="location.href='{{route('register')}}'">
      新規登録
    </button>
    @endguest

    {{-- ログイン済 --}}
    @auth
    <button class="dropdown-item" type="button" onclick="location.href=''">
      マイページ
    </button>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
      {{ __('Logout') }}
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
      @csrf
    </form>
    @endauth
  </div>
  <form id="logout-button" method="POST" action="">
  </form>
  <!-- Dropdown -->
</nav>