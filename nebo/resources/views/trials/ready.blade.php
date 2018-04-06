@extends('layouts.nebo')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Nebo</div>

                <div class="panel-body">
                    <div> Da click en la siguiente liga:  </div>
                     <br>
                    {{ HTML::link($url, $url) }}
                     <br>
                   </div>
                   <div>
                   	Las credenciales de acceso son: {{$cred}}
                   </div>
            </div>
        </div>
    </div>
</div>
@endsection
