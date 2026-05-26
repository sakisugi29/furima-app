@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('nav')
<form action="/" method="GET" class="search-form">
    <input type="search" name="search" placeholder="なにをお探しですか？" class="search-input">
</form>
<nav class="nav-menu">
    <form action="/logout" method="POST">
        @csrf
        <button type="submit" class="logout-button">ログアウト</button>
    </form>
    <a href="/mypage" class="mypage-link">マイページ</a>
    <form action="/sell" method="GET">
        <button type="submit" class="sell-button">出品</button>
    </form>
</nav>
@endsection

@section('content')
<div class="sell-container">
    <h1 class="sell-title">商品の出品</h1>
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color:red">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <form action="/sell" method="POST" enctype="multipart/form-data" class="sell-form">
        @csrf
        <div class="form-section">
            <label class="section-label">商品画像</label>
            <div class="image-upload-area">
                <label for="item_image" class="image-upload-label">
                    <span>画像を選択する</span>
                </label>
                <input type="file" id="item_image" name="item_image" class="image-input" accept="image/*">
            </div>
        </div>
        <div class="form-section">
            <label class="section-label detail-label">商品の詳細</label>

            <label class="field-label">カテゴリー</label>
            <div class="category-list">
                @foreach($categories as $category)
                <label class="category-tag">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="category-checkbox">
                    {{ $category->name }}
                </label>
                @endforeach
            </div>

            <label class="field-label">商品の状態</label>
            <select name="condition" class="condition-select">
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
            </div>
        <div class="form-section">
            <label class="section-label">商品名と説明</label>

            <label class="field-label">商品名</label>
            <input type="text" name="item_name" class="text-input" value="{{ old('item_name') }}">

            <label class="field-label">ブランド名</label>
            <input type="text" name="brand_name" class="text-input" value="{{ old('brand_name') }}">

            <label class="field-label">商品の説明</label>
            <textarea name="description" class="textarea-input">{{ old('description') }}</textarea>

            <label class="field-label">販売価格</label>
            <div class="price-input-wrap">
                <span class="yen-mark">¥</span>
                <input type="text" name="price" class="price-input" value="{{ old('price') }}" >
            </div>
        </div>

        <button type="submit" class="submit-button">出品する</button>
    </form>
</div>
@endsection