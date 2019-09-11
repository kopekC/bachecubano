@extends('user.layout')

@section('user_section')
<div class="page-content">
    <div class="inner-box">
        <div class="dashboard-box">
            <h2 class="dashbord-title">Configuración de cuenta</h2>
        </div>
        <div class="dashboard-wrapper">
            <div class="row form-dashboard">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mb-md-5">
                    <div class="privacy-box privacysetting">

                        <div class="dashboardboxtitle">
                            <h2>Preferencias de usuario:</h2>
                        </div>

                        <div class="dashboardholder mb-md-5">
                            <div class="user">
                                <!-- Drop Zone -->
                                <div class="dropzone" id="profile-photo-update" style="border: 2px dashed #0087F7; border-radius: 5px; background: white;">
                                    <div class="fallback">
                                        <input name="file" type="file" />
                                    </div>
                                </div>
                                <div class="usercontent mt-3">
                                    <form class="" method="post" action="{{ route('update_user') }}" id="user-data">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="name">Su nombre:</label>
                                            <input class="form-control" name="name" value="{{ Auth::user()->name }}">
                                        </div>
                                        <div class="form-group mb-3">
                                            <label for="name" class="text-left">Su celular:</label>
                                            <input class="form-control" name="name" value="{{ Auth::user()->phone }}">
                                        </div>

                                        <button class="btn btn-common btn-block" type="submit">Actualizar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!--
                        <div class="dashboardholder">
                            <form class="" method="post" action="{{ route('update_user') }}">
                                @csrf
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
                                <button class="btn btn-common btn-block" type="submit">Actualizar</button>
                            </form>
                        </div>
                        -->
                        
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="privacy-box deleteaccount">
                        <div class="dashboardboxtitle">
                            <h2>Eliminar mi cuenta:</h2>
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

@push('script')
<!-- Dropzone for the profile picture -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css">
@endpush

@push('script')
<!-- Dropzone for the profile picture -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
<script>
    Dropzone.options.profilePhotoUpdate = {
        uploadMultiple: false, //False this
        maxFilesize: 0.3,
        addRemoveLinks: false,
        dictDefaultMessage: "Arrastre su foto de perfil aquí",
        dictFileTooBig: "La imagen es demasiado grande",
        timeout: 10000,
        url: "{{ route('save-profile-image-ajax') }}?api_token=" + user_token,
        paramName: "photo",
        maxFiles: 1,
        acceptedFiles: 'image/*',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="token"]').attr('content')
        },

        //Submit form if saved name or ther data
        success: function(file, response) {
            if (response.status == 200) {
                $('#user-data').submit();
            }
        }
    };
</script>
@endpush

@endsection