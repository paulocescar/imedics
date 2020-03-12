@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card">

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        @if(Session::has('success'))
                        <div class="form-group row">
                            <div class="col-md-12">
                                <p id="success">Sua conta foi criada com sucesso.</p></a>
                            </div>
                        </div>
                        @endif
                        <div class="form-group row">
                            <div class="col-md-12">
                                <h3 class="titlelogin">Entre na sua conta</h3>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="E-mail" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="Senha" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary col-md-12">
                                    {{ __('Entrar') }}
                                </button>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12" id="accountActions">
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Esqueceu sua senha?') }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12" id="accountActions">
                                @if (Route::has('register'))
                                    <a class="btn btn-link" href="{{ route('register') }}">
                                        {{ __('Cadastre-se aqui') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
