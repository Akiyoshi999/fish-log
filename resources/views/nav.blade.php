<nav class="navbar navbar-expand-md navbar-dark bg-primary">
  <div class="container-fluid">

    <div class="d-flex justify-content-start mt-2">
      <a class="navbar-brand black-text" href="{{route('top')}}">釣果記録一覧</a>
      <form class="d-flex input-group w-auto" method="GET" action="{{route('search')}}">
        <input type="search" class="form-control rounded" placeholder="検索" aria-label="Search" name="word"
          aria-describedby="search-addon" />
        <button type="submit" class="input-group-text text-white border-0" id="search-addon">
          <i class="fas fa-search black-text"></i>
        </button>
      </form>
    </div>

    <div class="d-flex justify-content-end">
      @auth
      <a class="black-text mt-2" href="{{route('articles.create')}}">記事投稿</a>
      @endauth
      <!-- Dropdown -->
      <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        @auth
        <i class="{{ Auth::user()->icon }} black-text">
          {{ Auth::user() ? Auth::user()->name:"ゲスト" }}
        </i>
        @endauth
        @guest
        <i class="fas fa-user-circle black-text">
          {{ Auth::user() ? Auth::user()->name:"ゲスト" }}
        </i>
        @endguest
      </a>
      <div class=" dropdown-menu dropdown-menu-right dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
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
        <button class="dropdown-item" type="button"
          onclick="location.href='{{route("users.show",["user"=>Auth::user()])}}'">
          マイページ
        </button>
        <div class=" dropdown-divider">
        </div>
        <a class="dropdown-item ml-3" href="{{ route('logout') }}" onclick="event.preventDefault();
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
    </div>
  </div>
</nav>

@if (session('success_msg'))
<div class="alert alert-success" role="alert">
  {{ session('success_msg') }}
</div>
@endif
@if (session('err_msg'))
<div class="alert alert-danger" role="alert">
  {{ session('err_msg') }}
</div>
@endif