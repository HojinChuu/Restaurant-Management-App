@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">
                        <div class="col-sm-4">
                            <a href="/management">
                                <h4>관리자</h4>
                                <img src="{{ asset('img/management.png') }}" width="80px">
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="/cashier">
                                <h4>계산대</h4>
                                <img src="{{ asset('img/cashier.png') }}" width="80px">
                            </a>
                        </div>
                        <div class="col-sm-4">
                            <a href="/report">
                                <h4>영수증</h4>
                                <img src="{{ asset('img/report.png') }}" width="80px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
