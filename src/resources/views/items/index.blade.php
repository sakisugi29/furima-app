@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/item.css') }}">
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
        <div class="tab-container">
            <a href="/" class="tab-item {{ $tab != 'mylist' ? 'tab-active' : '' }}">おすすめ</a>
            <a href="/?tab=mylist&search={{ request('search') }}"  class="tab-item {{ $tab === 'mylist' ? 'tab-active' : '' }}">マイリスト</a>
        </div>
        <div class="item-container">
        @foreach ($items as $item)
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
        </div>
@endsection