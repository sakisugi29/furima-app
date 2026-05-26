@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/show.css') }}">
@endsection

@section('nav')
@auth
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
@endauth
@guest
    <form action="/" method="GET" class="search-form">
        <input type="search" name="search" placeholder="なにをお探しですか？" class="search-input" value="{{ request('search') }}">
    </form>
    <nav class="nav-menu">
        <form action="/login" method="POST">
            @csrf
            <button type="submit" class="login-button">ログイン</button>
        </form>
        <a href="/mypage" class="mypage-link">マイページ</a>
        <form action="/sell" method="GET">
            <button type="submit" class="sell-button">出品</button>
        </form>
    </nav>
@endguest
@endsection

@section('content')
<div class="container">
    <img src="{{ $item->item_image }}" alt="{{ $item->item_name }}" class="item-image">
    <div class="item-detail">
        <div class="product-info">
        <div class="name-area">
            <h2 class="item-name">{{ $item->item_name }}</h2>
            <p class="brand-name">{{ $item->brand_name }}</p>
        </div>
        <div class="price-area">
            <p class="item_price"><span class="price">¥</span>{{ number_format($item->price) }}<span class="tax">(税込)</span></p>
        </div>
        <div class="icons-area">
        <div class="like-area">
            @auth
                <form action="{{ route('items.like', $item->id) }}" method="POST">
                    @csrf
                    <button type="submit">
                        @if($item->likes->contains('user_id', Auth::id()))
                            <img src="{{ asset('images/ハートロゴ_ピンク.png')}}" class="like-icon">
                        @else
                            <img src="{{ asset('images/ハートロゴ_デフォルト.png')}}" class="like-icon">
                        @endif
                    </button>
                </form>
            @else
                <img src="{{ asset('images/ハートロゴ_デフォルト.png')}}" class="like-icon">
            @endauth
            <span class="like-count">{{ $item->likes->count() }}</span>
        </div>
        <div class="comment-area">
            <img src="{{ asset('images/ふきだしロゴ.png')}}" alt="コメント" class="comment-icon">
            <span class="comment-count">{{ $item->comments->count() }}</span>
        </div>
        </div>
        </div>
        @if($item->status === '販売中')
        <form action="/purchase/{{ $item->id }}" method="GET" class="purchase-form">
            @csrf
            <button type="submit" class="purchase-button">購入手続きへ</button>
        </form>
    @else
        <button class="purchase-button" disabled>売り切れ</button>
    @endif
        <div class="item-description">
            <h3 class="description-title">商品説明</h3>
            <div class="description-area">
                {{ $item->description }}
            </div>
        </div>
        <div class="item-data">
            <h3 class="data-title">商品の情報</h3>
            <div class="item-data-category">
                <span class="item-data-label">カテゴリー</span>
                <div class="category-tags">
                    @foreach($item->categories as $category)
                        <span class="category-tag">{{ $category->name }}</span>
                    @endforeach
                </div>
            </div>
            <div class="item-data-condition">
                <span class="item-data-label">商品の状態</span>
                <span class="condition-value">{{ $item->condition }}</span>
            </div>
        </div>
        <div class="item-comments">
            <h3 class="comment-title">コメント({{ $item->comments->count() }})</h3>
            @foreach($item->comments as $comment)
                <div class="comment-item">
                    <div class="comment-user">
                        <img src="{{ $comment->user->profile->profile_image ?? asset('images/default-avatar.png') }}" alt="" class="profile-image">
                        <span class="user-name">{{ $comment->user->name }}</span>
                    </div>
                    <p class="comment-text">{{ $comment->comment }}</p>
                </div>
            @endforeach
            <div class="comment-label">商品へのコメント</div>
            <form action="{{ route('item.comment',$item->id) }}" method="POST">
                @csrf
                @if($errors->has('comment'))
                    <p class="error-message">{{ $errors->first('comment') }}</p>
                @endif
                <textarea name="comment" class="comment-text-area" maxlength="255"></textarea>
                <button type="submit" class="comment-button">コメントを送信する</button>
            </form>
        </div>
    </div>
</div>
@endsection