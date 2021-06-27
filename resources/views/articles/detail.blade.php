<div class="card mt-3">
  <div class="card-body d-flex flex-row">
    <a href="{{route('users.show',['name'=>$article->user->name])}}" class="text-dark">
      <i class="fas fa-user-circle fa-3x mr-1"></i>
    </a>
    <div>
      <div class="font-weight-bold">
        <a href="{{route('users.show',['name'=>$article->user->name])}}" class="text-dark">
          {{ $article->user->name }}
        </a>
      </div>
      <div class="font-weight-lighter">{{ $article->created_at->format('Y/m/d H:i') }}</div>
    </div>

    @if( Auth::id() === $article->user_id )
    <!-- dropdown -->
    <div class="ml-auto card-text">
      <div class="dropdown">
        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-ellipsis-v"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="{{ route("articles.edit", ['article' => $article]) }}">
            <i class="fas fa-pen mr-1"></i>記事を更新する
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
            <i class="fas fa-trash-alt mr-1"></i>記事を削除する
          </a>
        </div>
      </div>
    </div>
    <!-- dropdown -->

    <!-- modal -->
    <div id="modal-delete-{{ $article->id }}" class="modal fade" tabindex="-1" role="dialog">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form method="POST" action="{{ route('articles.destroy', ['article' => $article]) }}">
            @csrf
            @method('DELETE')
            <div class="modal-body">
              {{ $article->title }}を削除します。よろしいですか？
            </div>
            <div class="modal-footer justify-content-between">
              <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
              <button type="submit" class="btn btn-danger">削除する</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- modal -->
    @endif

  </div>
  <div class="card-body pt-0">
    <h3 class="h4 card-title">
      <a class="text-dark" href="{{ route('articles.show', ['article' => $article]) }}">
        {{ $article->title }}
      </a>
    </h3>
    <div class="card-text">
      日時：{{ $article->date}}
    </div>
    <div class="card-text">
      場所：{{ $article->place}}
    </div>
    <div class="card-text">
      天気：{{ $article->weather}}
    </div>
    <div class="card-text">
      潮　：{{ $article->tide}}
    </div>
    <div class="card-text">
      気温：{{ $article->temperature}}
    </div>
    <div class="card-text">
      魚種：{{ $article->fish}}
    </div>
    <div class="card-text">
      長さ：{{ $article->length}} cm
    </div>
    <br />
    <div class="card-text text-dark">
      {{ $article->comment}}
    </div>
  </div>
  <div class="card-body">
    <img class="rounded" src="{{Storage::url($article->file_name)}}" alt="">
  </div>
  <div class=" card-body pt-0 pb-2 pl-3">
    <div class="card-text">
      <article-like :initial-is-liked-by='@json($article->isLikedBy(Auth::user()))'
        :initial-is-favorited-by='@json($article->isFavoritedBy(Auth::user()))'
        v-bind:initial-count-likes='@json($article->count_likes)' :authorized='@json(Auth::check())'
        like-endpoint="{{route('articles.like',['article'=>$article])}}"
        favorite-endpoint="{{route('articles.favorite',['article'=>$article])}}">
      </article-like>
    </div>
  </div>
  @foreach($article->tags as $tag)
  @if($loop->first)
  <div class="card-body pt-0 pb-4 pl-3">
    <div class="card-text line-height">
      @endif
      <a href="{{route('tags.show',['name'=>$tag->name])}}" class="border p-1 mr-1 mt-1 text-muted">
        {{ $tag->Hashtag}}
      </a>
      @if($loop->last)
    </div>
  </div>
  @endif
  @endforeach
</div>

@foreach ($article->comments as $article_comment)
<article-comment :comment-user='@json($article_comment->pivot->user->name)' :comment='@json($article_comment->content)'
  :authorized='@json(Auth::id() === $article_comment->pivot->user_id)'
  update-endpoint="{{route('articles.comment.update', ['article' => $article, 'comment'=>$article_comment]) }}"
  delete-endpoint="{{route('articles.comment.destroy',['article'=>$article,'comment'=>$article_comment])}}"
  url="{{route('articles.show',['article'=>$article])}}">
</article-comment>
@endforeach

<!-- ログイン済みの場合のみコメント投稿機能表示 -->
@auth
<form method="POST" action="{{ route('articles.comment.store',['article'=>$article]) }}">
  @csrf
  <div class="bg-light p-2">
    <div class="d-flex flex-row align-items-start">
      <img class="rounded-circle" src="https://i.imgur.com/RpzrMR2.jpg" width="40">
      <h5>{{ Auth::user()->name }}</h5>
    </div>
    <div class="pl-2 pt-2">
      <textarea name="content" class="form-control ml-1 shadow-none textarea">
    </textarea>
    </div>
    <div class="mt-2 text-right">
      <button class="btn btn-primary btn-sm shadow-none" type="submit">
        Post comment
      </button>
      <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button">Cancel</button>
    </div>
  </div>
</form>
@endauth

<!-- テスト -->
{{-- <form method="POST"
  action="{{ route('articles.comment.update',['article'=>$article,'comment'=>$article->comments->first()]) }}">
@csrf
@method('PUT')
<div class="bg-light p-2">
  <div class="d-flex flex-row align-items-start">
    <img class="rounded-circle" src="https://i.imgur.com/RpzrMR2.jpg" width="40">
    <h5>{{ Auth::user()->name }}</h5>
  </div>
  <div class="pl-2 pt-2">
    <textarea name="content" class="form-control ml-1 shadow-none textarea">
        {{$article->comments->first()->content}}
    </textarea>
  </div>
  <div class="mt-2 text-right">
    <button class="btn btn-primary btn-sm shadow-none" type="submit">
      Post comment
    </button>
    <button class="btn btn-outline-primary btn-sm ml-1 shadow-none" type="button">Cancel</button>
  </div>
</div>
</form> --}}

@if ($errors->any())
<div class="card-text text-left alert alert-danger">
  <ul class="mb-0">
    @foreach($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
  </ul>
</div>
@endif