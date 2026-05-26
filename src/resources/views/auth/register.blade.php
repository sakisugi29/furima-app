@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="register-container">
        <div class="register-container-title">会員登録</div>
        <form method="POST" action="/register" class="register-form">
            @csrf
            <div class="form-group">

            <div class="form-group-contents">
                <label for="name" class="register-form-label">ユーザー名</label>
                <input id="name" type="text" class="register-form-input" name="name" value="{{ old('name') }}" maxlength="20">
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-contents">
                <label for="email" class="register-form-label">メールアドレス</label>
                <input id="email" type="email" class="register-form-input" name="email" value="{{ old('email') }}">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror

            </div>

            <div class="form-group-contents">
                <label for="password" class="register-form-label">パスワード</label>
                <input id="password" type="password" class="register-form-input" name="password" value="{{ old('password') }}" >
                @error('password')
                    @if($message !== 'パスワードと一致しません')
                    <div class="error-message">{{ $message }}</div>
                    @endif
                @enderror
            </div>


            <div class="form-group-contents">
                <label for="password-confirm" class="register-form-label">確認用パスワード</label>
                <input id="password-confirm" type="password" class="register-form-input" name="password_confirmation" value="{{ old('password') }}">
                @error('password')
                    @if($message === 'パスワードと一致しません')
                    <div class="error-message">{{ $message }}</div>
                    @endif
                @enderror
            </div>
            </div>

            <div class="form-group-button">
                <button type="submit" class="register-form-button">登録する</button>
            </div>
            <div class="form-group-link">
                <a href="/login" class="register-form-link">ログインはこちら</a>
            </div>
            </div>
        </form>
    </div>
@endsection