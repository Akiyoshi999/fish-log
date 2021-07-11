<?php
$info = Config::get('view');
$weathers = $info['weather'];
$places = $info['place'];
$tides = $info['tide'];
$fishs = $info['fish'];
?>
@csrf
<div class="mb-3">
  <label for="title" class="form-label">タイトル</label>
  <input class="form-control" type="text" name="title" required value="{{ $article->title ?? old('title') }}">
</div>
<div class="form-group">
  <article-tags-input :initial-tags='@json($tagNames ?? [])' :autocomplete-items='@json($allTagNames ?? [])'>
  </article-tags-input>
</div>
<div class="form-group">
  <label for="date" class="form-label">日時：</label>
  <input class="" type="date" name="date" value="{{ $article->date ?? date('Y-m-d') }}" min="2000-01-01"
    max="2100-12-31">
</div>
<div class="form-group">
  <label for="place" class="form-label">場所：</label>
  <select name="place">
    @foreach ($places as $place)
    @if (isset($article) && $place == $article->place)
    <option value="{{ $place}}" selected>{{ $place}}</option>
    @else
    <option value="{{ $place }}">{{ $place }}</option>
    @endif
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="weather" class="form-label">天気：</label>
  <select name="weather">
    @foreach ($weathers as $weather)
    @if (isset($article) && $weather == $article->weather )
    <option value="{{ $weather }}" selected>{{ $weather }}</option>
    @else
    <option value="{{ $weather }}">{{ $weather }}</option>
    @endif
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="tide" class="form-label">潮　：</label>
  <select name="tide">
    @foreach ($tides as $tide)
    @if (isset($article) && $tide == $article->tide)
    <option value="{{ $tide }}" selected>{{ $tide}}</option>
    @else
    <option value="{{ $tide }}">{{ $tide}}</option>
    @endif
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="temperature" class="form-label">温度：</label>
  <input type="number" name="temperature" value="{{ $article->temperature ?? '0' }}" min="-10" max="50" value="15">
</div>
<div class="form-group">
  <label for="fish" class="form-label">魚種：</label>
  <select name="fish">
    @foreach ($fishs as $fish)
    @if (isset($article) && $fish == $article ?? ''->fish)
    <option value="{{ $fish }}" selected>{{ $fish}}</option>
    @else
    <option value="{{ $fish }}">{{ $fish}}</option>
    @endif
    @endforeach
  </select>
</div>
<div class="form-group">
  <label for="length" class="form-label">長さ：</label>
  <input id="length" name="length" type="number" value="{{ $article->length ?? '0' }}">
  <span>cm</span>
  <div class="form-group">
    <label for="comment" class="form-label">本文</label>
    <textarea name="comment" placeholder="" rows="10" class="form-control">
      {{ $article->comment ?? ''}}
  </textarea>
  </div>
  <div class="form-group">
    <!-- 画像表示の機能無効 
    <preview-image>
    -->
  </div>
</div>