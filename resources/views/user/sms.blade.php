@extends('user.layout')

@section('user_section')
<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">Enviar SMS a Cuba y el resto del mundo</h2>
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
                                    <form class="" method="post" action="{{ route('api_send_sms') }}">

                                        @csrf

                                        <div class="form-group mb-3">
                                            <label for="name">Saldo actual:</label>
                                            <input class="form-control" name="actual_balance" type="number" value="{{ $user->wallet->credits }}" disabled>
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="name">Número a enviar: (Debe contener el cóidigo del país)</label>
                                            <input class="form-control" name="phone" type="text" value="{{ old('phone') }}" maxlength="16" placeholder="5355149081">
                                        </div>

                                        <div class="form-group mb-3">
                                            <label for="name" class="text-left">Mensaje a enviar:</label>
                                            <textarea class="form-control" name="message" maxlength="150">{{ old('message') }}</textarea>
                                        </div>

                                        <div class="tg-checkbox">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="agree" checked>
                                                <label class="custom-control-label" for="tg-agreetermsandrules">Estoy de acuerdo con los <a href="#">Términos &amp; Condiciones</a></label>
                                                @error('agree')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <input type="hidden" name="api_token" value="{{ $user->api_token }}">
                                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                                        <input type="hidden" name="redirect_url" value="{{ URL::current() }}">

                                        <button class="btn btn-common btn-block" type="submit">Enviar SMS</button>
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