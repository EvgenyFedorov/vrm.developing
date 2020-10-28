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
                            Задания
                        </span>
                    </div>
                </div>
            </div>
            <div class="card">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" id="nav-home-tab" href="{{ url('/users') }}" role="tab" aria-controls="nav-home" aria-selected="true">Профиль</a>
                        <a class="nav-item nav-link active" id="nav-contact-tab" href="{{ url('/mobiles') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Телефоны</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" href="{{ url('/films') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Кинотека</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" href="{{ url('/seances') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Сеансы</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">Список Телефонов</div>
                                <div class="col-md-6" style="text-align: right;">
{{--                                    <a href="{{url('/logs/create')}}" style="color: #ffffff;" type="submit" class="btn btn-primary">--}}
{{--                                        {{ __('Добавить задание') }}--}}
{{--                                    </a>--}}
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 0; margin: 0;">
                            <table class="table table-hover table-bordered" style="margin: -1px 0 0 0;">
                                <tr>
                                    <th>ID</th>
                                    <th>Имя телефона</th>
                                    <th>Создан</th>
                                    <th>Сеанс</th>
                                    <th>Вкл/Выкл</th>
                                </tr>
                                @if(isset($data_mobiles) && $data_mobiles != false && count($data_mobiles) > 0)

                                    @foreach($data_mobiles as $data_mobile)

                                        <?php

                                        $class = ($data_mobile->status == 0) ? "default" : "table-success";

                                        ?>

                                        <tr id="tr_program_{{$data_mobile->id}}" class="{{$class}}">
                                            <td>{{$data_mobile->id}}</td>
                                            <td>{{$data_mobile->name}}</td>
                                            <td>{{$data_mobile->created_at}}</td>
                                            <td>
                                                @if(isset($data_mobile->seance->film->film_name) && $data_mobile->seance->film->film_name != null)
                                                    {{$data_mobile->seance->film->film_name}}
                                                @else
                                                    <div>Отсутствует</div>
                                                @endif
                                            </td>
                                            <td>
                                                <label class="switch">
                                                    @if($data_mobile->status == 0)
                                                        <input class="mobile_enable" id="{{$data_mobile->id}}" type="checkbox">
                                                    @else
                                                        <input class="mobile_enable" id="{{$data_mobile->id}}" type="checkbox" checked>
                                                    @endif
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align: center;">Телефоны отсутствуют!</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td colspan="7" style="text-align: center;">
                                        <div style="display: inline-block;">

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">...</div>
                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">...</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
