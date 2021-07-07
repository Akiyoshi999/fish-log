@extends('app')

@section('title','釣果情報')

@section('content')
@include('nav')

<main>
  <div class="container-fluid-full">
    <div class="p-md-5 text-white rounded bg-dark">
      <h1 class="display-4 font-italic">釣果記録</h1>
      <p class="lead my-3">
        釣果を検索したりあなたの釣果を記録してみましょう!
      </p>
    </div>
  </div>

  @foreach ($articles as $article)
  @include('articles.card')
  @endforeach
</main>
@endsection