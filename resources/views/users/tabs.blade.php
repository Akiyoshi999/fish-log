<ul class="nav nav-tabs nav-justified mt-3">
  <li class="nav-item">
    <a class="nav-link text-muted {{$hasArticles ? 'active':''}}" href="{{ route('users.show', ['user' => $user]) }}">
      記事
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-muted {{$hasFavorites ? 'active':''}}" href="{{route('users.favorites',['user'=>$user])}}">
      お気に入り
    </a>
  </li>
</ul>