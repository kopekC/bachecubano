@extends('user.layout')

@section('user_section')
<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">Transferir saldo entre usuarios</h2>
        </div>
        <div class="dashboard-wrapper">
            <div class="row form-dashboard">
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-6 mb-md-5">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="privacy-box privacysetting">

                        <div class="dashboardholder mb-md-5">
                            <div class="user">
                                <div class="usercontent mt-3">
                                    <form class="" method="post" action="{{ route('transfer_money_post') }}">
                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="name">Saldo actual:</label>
                                            <input class="form-control" name="actual_balance" type="number" value="{{ $user->wallet->credits }}" disabled>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="name">Correo a transferir:</label>
                                            <input class="form-control" name="email" type="email" value="">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="name" class="text-left">Cantidad a Transferir:</label>
                                            <input class="form-control" name="amount" value="" type="number" max="{{ $user->wallet->credits }}">
                                        </div>

                                        <button class="btn btn-common btn-block" type="submit">Enviar Saldo</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection