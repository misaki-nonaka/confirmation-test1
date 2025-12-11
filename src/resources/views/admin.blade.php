@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
@endsection

@section('nav')
@if (Auth::check())
<nav>
    <form action="/logout" method="post">
        @csrf
        <button class="header-nav__button">ログアウト</button>
    </form>
</nav>
@endif
@endsection

@section('title', 'Admin')

@section('content')
<div class="admin-content">
    <div class="search-form__content">
        <form action="/search" method="get">
            @csrf
            <input type="text" class="search-form__input" name="keyword" placeholder="名前やメールアドレスを入力してください">
            <select name="gender" class="search-form__gender">
                <option value="">性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
            <select name="category_id" class="search-form__category">
                <option value="">お問い合わせの種類</option>
                @foreach($categories as $category)
                <option value="{{ $category['id'] }}">{{ $category['content'] }}</option>
                @endforeach
            </select>
            <input type="date" class="search-form__date" name="date">
            <button class="search-form__button-submit" type="submit">検索</button>
        </form>
        <form action="/reset" method="get">
            @csrf
            <button class="search-form__button-reset" type="submit">リセット</button>
        </form>
    </div>
    <div class="contact-list">
        <div class="contact-list__topper">
            <button>エクスポート</button>
            <div class="pagination">
                {{ $items->links() }}
            </div>
        </div>
        <table class="contact-table">
            <tr class="contact-table__heading">
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
            @foreach($items as $item)
            <tr class="contact-table__content">
                <td>{{ $item['last_name'] . "　" . $item['first_name'] }}</td>
                <td>
                    @switch($item['gender'])
                        @case(1)
                            男性
                        @break;
                        @case(2)
                            女性
                        @break;
                        @case(3)
                            その他
                        @break;
                    @endswitch
                </td>
                <td>{{ $item['email'] }}</td>
                <td>{{ $item->category->content }}</td>
                <td><a href="#modal-{{ $item['id'] }}">詳細</a></td>
            </tr>
            @endforeach
        </table>

        @foreach($items as $item)
        <div class="modal" id="modal-{{ $item['id'] }}">
            <div class="modal-content">
                <a href="#" class="modal-close">×</a>
                <table class="modal-table">
                    <tr>
                        <th>お名前</th>
                        <td>{{ $item['last_name'] . "　" . $item['first_name'] }}</td>
                    </tr>
                    <tr>
                        <th>性別</th>
                        <td>
                            @switch($item['gender'])
                                @case(1)
                                    男性
                                @break;
                                @case(2)
                                    女性
                                @break;
                                @case(3)
                                    その他
                                @break;
                            @endswitch
                        </td>
                    </tr>
                    <tr>
                        <th>メールアドレス</th>
                        <td>{{ $item['email'] }}</td>
                    </tr>
                    <tr>
                        <th>電話番号</th>
                        <td>{{ $item['tel'] }}</td>
                    </tr>
                    <tr>
                        <th>住所</th>
                        <td>{{ $item['address'] }}</td>
                    </tr>
                    <tr>
                        <th>建物名</th>
                        <td>{{ $item['building'] }}</td>
                    </tr>
                    <tr>
                        <th>お問い合わせの種類</th>
                        <td>{{ $item->category->content }}</td>
                    </tr>
                    <tr>
                        <th>お問い合わせ内容</th>
                        <td>{{ $item['detail'] }}</td>
                    </tr>
                </table>
                <form action="/delete" method="post" class="delete-form">
                    @method('DELETE')
                    @csrf
                    <div class="delete-form__button">
                        <input type="hidden" name="id" value="{{ $item['id'] }}">
                        <button type="submit">削除</button>
                    </div>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection