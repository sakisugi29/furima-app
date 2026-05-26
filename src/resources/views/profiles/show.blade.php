@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
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
<div class="profile-container">
    <div class="profile-section">
        <div class="profile-image">
            <img src="{{ $profile->profile_image ?? asset('images/default_profile.png') }}" alt="" class="profile-img">
        </div>
        <div class="profile-info">
            <h2 class="profile-name">{{ $user->name ?? 'ユーザー名' }}</h2>
        </div>
    <div class="profile-edit">
        <a href="/mypage/profile" class="edit-button">プロフィールを編集</a>
    </div>
    </div>
</div>
        <div class="tab-container">
    <a href="/mypage?page=sell" class="tab-item {{ $tab === 'sell' ? 'tab-active' : '' }}">出品した商品</a>
    <a href="/mypage?page=buy" class="tab-item {{ $tab === 'buy' ? 'tab-active' : '' }}">購入した商品</a>
</div>
<div class="item-container">
    @if($tab === 'buy')
        @foreach ($purchasedItems as $purchase)
        <div class="item-card">
            <a href="/item/{{ $purchase->item->id }}" class="item-link">
                <img src="{{ $purchase->item->item_image }}" alt="{{ $purchase->item->item_name }}" class="item-image">
                <div class="item-info">
                    <h3 class="item-name">{{ $purchase->item->item_name }}</h3>
                </div>
            </a>
        </div>
        @endforeach
    @else
        @foreach ($sellingItems as $item)
        <div class="item-card">
            <a href="/item/{{ $item->id }}" class="item-link">
                <img src="{{ $item->item_image }}" alt="{{ $item->item_name }}" class="item-image">
                @if ($item->status === 'sold_out')
                <div class="sold-overlay">
                    <span class="sold-text">Sold</span>
                </div>
                @endif
                <div class="item-info">
                    <h3 class="item-name">{{ $item->item_name }}</h3>
                </div>
            </a>
        </div>
        @endforeach
    @endif
</div>
</div>
@endsection