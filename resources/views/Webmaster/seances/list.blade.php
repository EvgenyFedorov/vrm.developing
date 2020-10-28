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
                            Сеансы
                        </span>
                    </div>
                </div>
            </div>
            <div class="card">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-item nav-link" id="nav-home-tab" href="{{ url('/users') }}" role="tab" aria-controls="nav-home" aria-selected="true">Профиль</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" href="{{ url('/mobiles') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Телефоны</a>
                        <a class="nav-item nav-link" id="nav-contact-tab" href="{{ url('/films') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Кинотека</a>
                        <a class="nav-item nav-link active" id="nav-contact-tab" href="{{ url('/seances') }}" role="tab" aria-controls="nav-contact" aria-selected="false">Сеансы</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-4">Список доступных фильмов:</div>
                                <div class="col-md-4" style="text-align: right;">
                                    <select class="form-control" id="select_film">
                                        @foreach($data_films as $data_film)
                                            @if(isset($data_film->order) && $data_film->order != null)
                                                <option value="{{$data_film->id}}">{{$data_film->film_name}}</option>
                                            @else
                                                <option selected disabled>{{$data_film->film_name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <input type="hidden" value="" id="film_id">
                                </div>
                                <div class="col-md-4">
                                    @if($data_mobiles === false)
                                        <div style="font-size: 12px">Для того что бы начать сеанс, необходимо активировать хотя бы 1 телефон</div>
                                    @else
                                        <div style="color: #ffffff;" class="btn btn-primary start_seances">
                                            Создать сеанс
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="padding: 0; margin: 0;">
                            <table class="table table-hover table-bordered" style="margin: -1px 0 0 0;">
                                <tr>
                                    <th>ID</th>
                                    <th>IMG</th>
                                    <th>Название фильма</th>
                                    <th>Действие</th>
                                </tr>
                                @if(isset($data_seances) AND count($data_seances) > 0)

                                    @foreach($data_seances as $data_seance)

                                        <?php
                                        $class = ($data_seance->status == 0) ? "default" : "table-success";
                                        ?>

                                        <tr id="tr_film_{{$data_seance->id}}" class="{{$class}}">
                                            <td>{{$data_seance->id}}</td>
                                            <td>{{$data_seance->film_id}}</td>
                                            <td>{{$data_seance->film->film_name}}</td>
                                            <td style="padding: 0; text-align: center;">
                                                @if($data_seance->status == 1)
                                                    <div class="play_seance" id="{{$data_seance->id}}" style="display: inline-block; font-size: 40px; cursor: pointer;" title="Запустить сеан">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-play-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                                                        </svg>
                                                    </div>
                                                @elseif($data_seance->status == 2)
                                                    <div class="pause_seance" id="{{$data_seance->id}}" style="display: inline-block; font-size: 40px; cursor: pointer;" title="Поставить на паузу">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-pause-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M5.5 3.5A1.5 1.5 0 0 1 7 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5zm5 0A1.5 1.5 0 0 1 12 5v6a1.5 1.5 0 0 1-3 0V5a1.5 1.5 0 0 1 1.5-1.5z"/>
                                                        </svg>
                                                    </div>
                                                @elseif($data_seance->status == 3)
                                                    <div class="play_seance" id="{{$data_seance->id}}" style="display: inline-block; font-size: 40px; cursor: pointer;" title="Запустить сеан">
                                                        <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-play-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M11.596 8.697l-6.363 3.692c-.54.313-1.233-.066-1.233-.697V4.308c0-.63.692-1.01 1.233-.696l6.363 3.692a.802.802 0 0 1 0 1.393z"/>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" style="text-align: center;">Сеансы отсутствуют!</td>
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
