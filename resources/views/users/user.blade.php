<user-profile-edit></user-profile-edit>
<div class="card mt-3">
  <!-- Buttons trigger collapse -->
  <p>
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
      aria-controls="collapseExample">
      Link with href
    </a>
  </p>
  <div class="collapse" id="collapseExample">
    <div class="card card-body">
      Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. Nihil anim
      keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident.
    </div>
  </div>

  <!-- test -->

  <div class="card-body">
    <div class="d-flex flex-row">
      <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
        <i class="fas fa-user-circle fa-3x"></i>
      </a>


      @if (Auth::id() !== $user->id)
      <follow-button class="ml-auto" v-bind:initial-is-followed-by='@json($user->isFollowedBy(Auth::user()))'
        v-bind:authorized='@json(Auth::check())' endpoint='{{route("users.follow",["name"=>$user->name])}}'>
      </follow-button>
      @endif

      <!-- Button trigger modal -->
      <div class="pull-right pl-5">
        <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#staticBackdrop">
          プロフィールを編集
        </button>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">プロフィールの編集</h5>
              <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <form>
                <div class="mb-3">
                  <label for="recipient-name" class="col-form-label">ユーザアイコン:</label><br />
                  <i class="fas fa-user-circle fa-3x mb-3"></i>
                  <a class="mb-3" data-mdb-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false"
                    aria-controls="collapseExample">アイコンを選択</a>
                  <br />
                  <div class="border-bottom mb-2"></div>
                  {{-- <div class="collapse" id="collapseExample"> --}}
                  <div class="container">
                    <div class="row row-cols-5">
                      <div class="col">
                        <i class="fas fa-user-circle fa-2x "></i><br />
                      </div>
                      <div class="col">Column</div>
                      <div class="col">Column</div>
                      <div class="col">Column</div>
                      <div class="col">Column</div>
                    </div>
                    {{-- </div> --}}
                  </div>
                  <div class="border-bottom mb-2"></div>
                  <label for="recipient-name" class="col-form-label">ユーザーネーム:</label>
                  <input type="text" class="form-control" id="recipient-name" value="{{$user->name}}">
                </div>
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
              <button type="button" class="btn btn-primary">更新する</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <h2 class="h5 card-title m-0">
      <a href="{{ route('users.show', ['name' => $user->name]) }}" class="text-dark">
        {{ $user->name }}
      </a>
    </h2>
  </div>
  <div class="card-body">
    <div class="card-text">
      <a href="{{route('users.followings',['name'=>$user->name])}}" class="text-muted">
        {{$user->count_followings}} フォロー
      </a>
      <a href="{{route('users.followers',['name'=>$user->name])}}" class="text-muted">
        {{$user->count_followers}} フォロワー
      </a>
    </div>
  </div>
</div>