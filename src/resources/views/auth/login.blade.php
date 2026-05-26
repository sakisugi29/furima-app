@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection


@section('content')
<div class="container">
    <div class="login-container">
    <div class="login-container-title">ログイン</div>
    <form method="POST" action="/login" class="login-form">
        @csrf
        <div class="form-group">
            <div class="form-group-contents">
                <label for="email" class="login-form-label">メールアドレス</label>
                <input id="email" type="email" class="login-form-input" name="email" value="{{ old('email') }}" >
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-contents">
                <label for="password" class="login-form-label">パスワード</label>
                <input id="password" type="password" class="login-form-input" name="password"  >
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-button">
                <button type="submit" class="login-form-button">ログインする</button>
            </div>
            <div class="form-group-link">
                <a href="/register" class="login-form-link">会員登録はこちら</a>
            </div>
        </div>
    </form>
    </div>
</div>
@endsection