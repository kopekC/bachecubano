<!-- Content section Start -->
<section class="register section-padding">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-12 col-xs-12">
                <div class="register-form login-area">
                    <h3>Crear mi cuenta en Bachecubano</h3>

                    <div class="text-center m-3">
                        <a class="btn btn-common btn-block text-white" href="{{ route('facebook_login') }}"><i class="lni-facebook-filled"></i> Registrarte con Facebook</a>
                    </div>

                    <div class="text-center m-3">
                        <a class="btn btn-common btn-block text-white" style="background-color: #1bd0ee" href="{{ route('twitter_login') }}"><i class="lni-twitter-filled"></i> Registrarte con Twitter</a>
                    </div>

                    <hr>

                    <form class="login-form" method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-user"></i>
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Nombre" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-envelope"></i>
                                <input id="sender-email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Correo Electrónico" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Contraseña" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-icon">
                                <i class="lni-lock"></i>
                                <input id="password-confirm" type="password" class="form-control" placeholder="Repite la Contraseña" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <!-- Recaptcha Show -->
                        <div class="form-group">
                            {{-- reCaptcha Robot Captcha --}}
                            @error ('g-recaptcha-response')
                            <div class="alert alert-danger">
                                {{ $message }}
                            </div>
                            @endif
                            {!! htmlFormSnippet() !!}
                        </div>

                        <div class="form-group mb-3 text-center">
                            <div class="checkbox">
                                <input type="checkbox" name="rememberme" value="rememberme">
                                <label>Aceptas <a href="{{ route('terms') }}">Términos &amp; Condiciones</a> ok?</label>
                            </div>
                        </div>

                        <div class="text-center">
                            <button class="btn btn-common log-btn" type="submit">Registrarme</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Content section End -->