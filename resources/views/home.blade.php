@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center text-center">
        <div class="col-md-8">
            <h1 class="p-4" style="font-weight: bolder; font-size: 58px">
                <img src="https://www.waselegypt.com/images/main-title.png">
            </h1>
            <h2 class="heading p-4">التنقل بين مراكز المحافظة بكل سهولة</h2>
            <p>
                @auth
                <a href="{{ route('home') }}" class="btn btn-outline-light btn-lg">انتقل لحجز الرحله</a>
                @else
                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">تسجيل الدخول لحجز رحلتك</a>
                @endauth
            </p>
        </div>
    </div>
</div>
@endsection
