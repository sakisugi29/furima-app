@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/profile-edit.css') }}">
@endsection

@section('nav')
<form action="/" method="GET" class="search-form">
        <input type="search" name="search" placeholder="なにをお探しですか？" class="search-input" value="{{ request('search') }}">
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
<div class="profile-edit-container">
    <h1 class="profile-edit-title">プロフィール編集</h1>
    <form action="/mypage/profile" method="POST" class="profile-edit-form" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="profile-image-section">
            <label for="profile_image" class="profile-image-label">
                <img src="{{ $profile->profile_image ?? asset('images/default_profile.png') }}" alt="" class="profile-img-preview">
            </label>
            <label for="profile_image" class="image-select-button">
            画像を選択する
            </label>
            <input type="file" id="profile_image" name="profile_image" class="profile-image-input" accept="image/*">
    </div>
    <div class="profile-info-section">
        <label for="name" class="profile-info-label">ユーザー名</label>
        <input type="text" id="name" name="name" class="profile-info-input" value="{{ old('name', $user->name) }}" required>

        <label for="postal_code" class="profile-info-label">郵便番号</label>
        <input type="text" id="postal_code" name="postal_code" class="profile-info-input" value="{{ old('postal_code',$profile->postal_code) }}">

        <label for="address" class="profile-info-label">住所</label>
        <input type="text" id="address" name="address" class="profile-info-input" value="{{ old('address', $profile->address)}}">

        <label for="building" class="profile-info-label">建物名</label>
        <input type="text" id="building" name="building" class="profile-info-input" value="{{ old('building', $profile->building) }}">

        <div class="edit-button-area">
        <button type="submit" class="edit-button">更新する</button>
        </div>
    </div>
    </form>
</div>
@endsection