@extends('user.layout')

@section('user_section')
<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">Configuración de cuenta</h2>
        </div>
        <div class="dashboard-wrapper">
            <div class="row form-dashboard">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="privacy-box privacysetting">
                        <div class="dashboardboxtitle">
                            <h2>Preferencias de usuario</h2>
                        </div>
                        <div class="dashboardholder">
                            <form class="" method="post" action="{{ route('update_user') }}">
                                <ul>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="privacysettingsone">
                                            <label class="custom-control-label" for="privacysettingsone">Make my profile photo
                                                public</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="privacysettingstwo">
                                            <label class="custom-control-label" for="privacysettingstwo">I want to receive monthly
                                                newsletter</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="privacysettingsthree">
                                            <label class="custom-control-label" for="privacysettingsthree">I want to receive e-mail
                                                notifications of offers/messages</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="privacysettingsfour">
                                            <label class="custom-control-label" for="privacysettingsfour">I want to receive e-mail
                                                alerts about new listings</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="privacysettingsfive">
                                            <label class="custom-control-label" for="privacysettingsfive">Enable offers/messages
                                                option in all my ads Post</label>
                                        </div>
                                    </li>
                                </ul>
                                <button class="btn btn-common" type="submit">Actualizar</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="privacy-box deleteaccount">
                        <div class="dashboardboxtitle">
                            <h2>Eliminar mi cuenta</h2>
                        </div>
                        <div class="dashboardholder">
                            <h5 class="text-center">¡Atención! Esta operación es irreversible.</h5>
                            <form action="{{ route('delete_account') }}" method="post" onsubmit="return confirm('¿Está seguro de eliminar su cuenta? ¡Última advertencia!');">
                                @csrf
                                <div class="form-group">
                                    <textarea class="form-control" placeholder="Déjanos saber en qué podemos mejorar" name="feedback"></textarea>
                                </div>
                                <button class="btn btn-danger btn-block" type="submit">Eliminar cuenta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection