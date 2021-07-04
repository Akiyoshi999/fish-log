<ul class="nav nav-tabs nav-justified mt-3">
  <li class="nav-item">
    <a class="nav-link text-muted {{$hasFollowings ? 'active':''}}"
      href="{{ route('users.followings', ['user' => $user]) }}">
      フォローリスト
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link text-muted {{$hasFollowers ? 'active':''}}" href="{{route('users.followers',['user'=>$user])}}">
      フォロワーリスト
    </a>
  </li>
</ul>