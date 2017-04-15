@extends('weblog::layout')

@section('content')
    <div class="md-cell mdl-cell--1-col mdl-cell--1-offset">
        <a class="mdl-button mdl-js-button mdl-button--fab mdl-js-ripple-effect mdl-button--colored"
            href="/logs">
          <i class="material-icons">keyboard_arrow_left</i>
        </a>
    </div>
    <div class="mdl-shadow--2dp text-container md-cell mdl-cell--8-col">
        <pre>
            {{$text}}
        </pre>
    </div>
@endsection