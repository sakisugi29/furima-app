@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
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
<form action="{{ route('purchase.store', $item->id) }}" method="POST">
            @csrf
            <input type="hidden" name="address" value="{{ Auth::user()->addresses()->first()->address ?? '' }}">
<div class="container">
    <div class="purchase-left">
        <div class="item-details">
        <img src="{{ $item->item_image }}" alt="{{ $item->item_name }}" class="item-image">
    <div class="item-info">
        <h2 class="item-name">{{ $item->item_name }}</h2>
        <p class="item-price">¥ {{ number_format($item->price) }}</p>
    </div>
    </div>
    <div class="payment-method">
        <div class="payment-title">
        <p class="payment-label">支払い方法</p>
        </div>
        <select name="payment_method" id="payment_method" class="payment-method-select" required>
            <option value>選択してください</option>
            <option value="コンビニ">コンビニ</option>
            <option value="カード払い">カード払い</option>
        </select>
    </div>
    <div class="shipping-address">
        <div class="shipping-header">
        <p class="shipping-label">配送先住所</p>
        <a href="/purchase/address/{{ $item->id }}" class="address-link">変更する</a>
        </div>
        <div class="current-address">
            <p class="current-address-text">
                {{ Auth::user()->addresses()->first()->address ?? '住所が登録されていません' }}</p>
        </div>
    </div>
    </div>
    <div class="purchase-right">
    <div class="order-summary">
        <div class="order-row">
            <span class="order-label">商品代金</span>
            <span class="order-value">¥ {{ number_format($item->price) }}</span>
        </div>
        <div class="order-row">
            <span class="order-label">支払い方法</span>
            <span class="order-value" id="selected-payment">選択してください</span>
        </div>
    </div>
    <div class="purchase-button">
            <button type="submit" class="buy-button">購入する</button>
    </div>
    </div>
</div>
</form>
@endsection

@section('js')
<script>
    document.getElementById('payment_method').addEventListener('change', function() {
        const options = {
            'コンビニ': 'コンビニ払い',
            'カード払い': 'カード払い',
            '': '選択してください'
        };
        document.getElementById('selected-payment').textContent = options[this.value];
    });
</script>
@endsection