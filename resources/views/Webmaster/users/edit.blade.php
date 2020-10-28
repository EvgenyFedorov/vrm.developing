@extends('Webmaster.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div style="margin: 0 0 20px 0;">
                        <span>
                            <a href="{{url('/')}}">Главная</a>
                        </span>&nbsp;-&nbsp;
                        <span>Редактирование профиля</span>
                    </div>
                </div>
            </div>
            <div class="card">
{{--                <form method="PUT" action="{{ url('/users/' . $edit_user->id) }}">--}}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Профиль</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" href="{{ url('/mobiles') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Телефоны</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" href="{{ url('/films') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Кинотека</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" href="{{ url('/seances') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Сеансы</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="card-header" style="text-align: center; font-size: 19px;">
                                Редактирование профиля
                            </div>
                            <div class="card-body" style="padding: 20px 0 20px 0; margin: 0;">
                                @csrf

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Имя') }}</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$edit_user->users_name}}" required autocomplete="name" autofocus>

                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail адрес') }}</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$edit_user->email}}" required autocomplete="email">

                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Пароль') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="text" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Повторите пароль') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="text" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="user_enable" class="col-md-4 col-form-label text-md-right">
{{--                                        {{ __('Активация') }}--}}
                                    </label>

                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <button type="submit" class="btn btn-primary" id="update_user_info">
                                                    {{ __('Сохранить') }}
                                                </button>
                                            </div>
                                            <div class="col-md-6" style="text-align: center;">
                                                <div class="btn btn-default" style="margin: 0 -60px 0 0;" id="generic_password">
                                                    <span style="font-size: 17px; color: #007bff; text-decoration: underline; cursor: pointer; ">Сгенерировать пароль</span>&nbsp;
                                                    <i class="fa fa-random"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
{{--                </form>--}}
            </div>
        </div>
    </div>
</div>
<input id="program_id" value="" type="hidden">
<input id="job_id" value="" type="hidden">
<input id="user_id" value="{{$edit_user->id}}" type="hidden">
@endsection
