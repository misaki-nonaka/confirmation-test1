@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/confirm.css') }}">
@endsection

@section('title', 'Confirm')

@section('content')
<div class="contact-form__content">
    <form action="/thanks" method="POST" class="form">
        @csrf
        <table class="form__table">
        <tr class="table__row">
            <th>お名前</th>
            <td>
                <input type="hidden" name="last_name" value="{{ $contents['last_name'] }}">
                <input type="hidden" name="first_name" value="{{ $contents['first_name'] }}">
                {{ $contents['last_name'] . "　" . $contents['first_name'] }}
            </td>
        </tr>
        <tr class="table__row">
            <th>性別</th>
            <td>
                @switch($contents['gender'])
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
                <input type="hidden" name="gender" value="{{ $contents['gender'] }}">
            </td>
        </tr>
        <tr class="table__row">
            <th>メールアドレス</th>
            <td>
                <input type="text" name="email" value="{{ $contents['email'] }}" readonly>
            </td>
        </tr>
        <tr class="table__row">
            <th>電話番号</th>
            <td>
                {{ $contents['tel1'] . $contents['tel2'] . $contents['tel3'] }}
                <input type="hidden" name="tel1" value="{{ $contents['tel1'] }}">
                <input type="hidden" name="tel2" value="{{ $contents['tel2'] }}">
                <input type="hidden" name="tel3" value="{{ $contents['tel3'] }}">
            </td>
        </tr>
        <tr class="table__row">
            <th>住所</th>
            <td>
                <input type="text" name="address" value="{{ $contents['address'] }}" readonly>
            </td>
        </tr>
        <tr class="table__row">
            <th>建物名</th>
            <td>
                <input type="text" name="building" value="{{ $contents['building'] }}" readonly>
            </td>
        </tr>
        <tr class="table__row">
            <th>お問い合わせの種類</th>
            <td>
                <input type="text" value="{{ $category['content'] }}" readonly>
                <input type="hidden" name='category_id' value="{{ $category['id'] }}">
            </td>
        </tr>
        <tr class="table__row">
            <th>お問い合わせ内容</th>
            <td>
                    <input type="text" name="detail" value="{{ $contents['detail'] }}" readonly>
            </td>
        </tr>
        </table>
        <div class="form__button">
            <button class="form__button-submit" type="submit" value="complete">送信</button>
            <button class="form__button-back" name='back' type="submit" value="back">修正</button>
        </div>
    </form>
</div>


@endsection