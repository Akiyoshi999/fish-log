@extends('app')

@section('title','釣果情報')

@section('content')
@include('nav')

<main class="container">
  <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
    <div class="col-md-6 px-0">
      <h1 class="display-4 font-italic">釣果記録</h1>
      <p class="lead my-3">みなさんの釣果やあなたの釣果を記録してみましょう!</p>
    </div>
  </div>

  @foreach ($articles as $article)

  <div class="row mb-2">
    <div class="col-md-12">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-4 d-flex flex-column position-static">
          <i class="fas fa-user-circle">
            {{$article->user->name}}
          </i>
          <h3 class="mb-0">
            {{$article->title}}
          </h3>
          <div class="mb-1 text-muted">
            {{$article->date}}
          </div>
          {{-- <p class="card-text mb-auto">これは写真の解説文付きのカードです。自然に説明を加えることができます。</p> --}}
          <a href="#" class="stretched-link">続きを読む</a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img"
            aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            <title>Placeholder</title>
            <rect width="100%" height="100%" fill="#55595c" /><text x="50%" y="50%" fill="#eceeef"
              dy=".3em">Thumbnail</text>
          </svg>

        </div>
      </div>
    </div>
  </div>
  @endforeach

</main><!-- /.container -->
@endsection