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
                        <span>
                            <a href="{{url('/programs')}}">Задания</a>
                        </span>&nbsp;-&nbsp;
                        <span>Редактирование задания: <span>#{{$edit_job->jobs_id}}</span></span>
                    </div>
                </div>
            </div>
            <div class="card">
{{--                <form method="POST" action="{{ url('/programs') }}">--}}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link" id="nav-home-tab" href="{{ url('/users') }}" role="tab" aria-controls="nav-home" aria-selected="true">Профиль</a>
                            <a class="nav-item nav-link active" id="nav-contact-tab" href="{{ url('/logs') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Задания</a>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="card-header" style="text-align: center; font-size: 19px;">
                                Редактирование задания:
                                <span style="font-weight: bold;">#{{$edit_job->jobs_id}}</span>
                            </div>
                            <div class="card-body" style="padding: 20px 0 20px 0; margin: 0;">
                                @csrf

                                <div class="form-group row">
                                    <label for="job_code" class="col-md-4 col-form-label text-md-right">{{ __('Код') }}</label>

                                    <div class="col-md-6">
                                        <input id="job_code" type="text" class="form-control @error('job_code') is-invalid @enderror" name="job_code" value="{{$edit_job->code_id}}" required autocomplete="job_code" autofocus>

                                        @error('job_code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row" id="program_block_select_users_btn">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">
                                        {{ __('Изменить приложение') }}
                                    </label>

                                    <div class="col-md-6">
                                        <div type="button" data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-success">
                                            {{ __('Показать список') }}
                                        </div>
                                    </div>

                                    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <table class="table table-hover table-bordered" style="margin: -1px 0 0 0;">
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Название прилы</th>
                                                        <th>Название прилы для бота</th>
                                                        <th>Дата добавления</th>
                                                        <th>Выбрать</th>
                                                    </tr>
                                                    @if(isset($programs) AND count($programs) > 0)

                                                        <?php
                                                            $ids = "";
                                                        ?>

                                                        @foreach($programs as $program)

                                                            <?php
                                                                $class = ($program->enable == 1) ? "default" : "table-danger";

                                                            ?>

                                                            <tr class="{{$class}}">
                                                                <td>{{$program->id}}</td>
                                                                <td>{{$program->name}}</td>
                                                                <td>{{$program->bot_name}}</td>
                                                                <td>{{$program->created_at}}</td>
                                                                <td>
                                                                    <label class="switch">
                                                                        @if($edit_job->programs_id == $program->id))

                                                                            <input class="program_job_select" id="{{$program->id}}" checked type="checkbox">
                                                                        @else
                                                                            <input class="program_job_select" id="{{$program->id}}" type="checkbox">
                                                                        @endif
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="7" style="text-align: center;">Задание не найдено!</td>
                                                        </tr>
                                                    @endif
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary" id="job_save_execute">
                                            {{ __('Сохранить Задание') }}
                                        </button>
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
<input id="job_id" value="{{$edit_job->jobs_id}}" type="hidden">
<input id="program_id" value="{{$edit_job->programs_id}}" type="hidden">
@endsection
