<div class="container">
  <div class="card mt-3">
    <div class="card-body d-flex flex-row no-gutters">
      <div class="col-md-12">
        <div class="card-body">
          <div class="row">
            <div class="col-md-11">
              <a href="{{route('users.show',['user'=>$article->user])}}" class="text-dark">
                <i class="{{ $article->user->icon}} fa-3x mr-1"></i>
              </a>
              <a class="fs-3 font-weight-bold text-dark font-big"
                href="{{route('users.show',['user'=>$article->user])}}" class="text-dark">
                {{ $article->user->name }}
              </a>
              <span class="ml-2 text-muted font-weight-bold">
                {{ date('Y年m月d日',strtotime($article->date)) }}
              </span>
              <div class="text-muted font-weight-bold">
                <i class="fas fa-fish fa-sm text-muted">
                  <span class="ml-1">
                    {{ $article->fish }}
                  </span>
                </i>
                <span class="ml-2">{{$article->length }}cm</span>
                <i class="fas fa-heart ml-3 mr-1 fa-sm text-muted">
                  {{$article->count_likes}} いいね</i>
              </div>
            </div>
            <!-- dropdown -->
            @if( Auth::id() === $article->user_id )
            <div class="col-md-1">
              <div class="dropdown">
                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fas fa-ellipsis-v "></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ route("articles.edit", ['article' => $article]) }}">
                    <i class="fas fa-pen mr-1"></i>記事を更新する
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-danger" data-toggle="modal"
                    data-target="#modal-delete-{{ $article->id }}">
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
            @endif
            <!-- modal -->
          </div>
        </div>
        <div class="ml-3">
          <a class="text-dark" href="{{route('articles.show',['article'=>$article])}}">
            <h4 class="card-title">{{ $article->title }}</h4>
            <div class="card-text">
              {{ $article->limitComment($article->comment) }}
            </div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>