@extends('layouts.nebo')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-1">
            <img src="{{asset('img/Nebo-Blanco.png')}}" class="float-left" alt="Nebo" width="400" height="400"> 
        </div>
        <div class="col-md-6 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Nebo</div>

                <div class="panel-body">
                    <form class="form-horizontal" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="name" class="col-md-4 control-label">Nombre</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control" name="name" required autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="last_name" class="col-md-4 control-label">Apellidos</label>

                            <div class="col-md-6">
                                <input id="last_name" type="text" class="form-control" name="last_name" required autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="company" class="col-md-4 control-label">Empresa</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control" name="company" required autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="job_position" class="col-md-4 control-label">Puesto</label>

                            <div class="col-md-6">
                                <input id="job_position" type="text" class="form-control" name="job_position" required autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-md-4 control-label">Teléfono</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" placeholder="(52) 1234 5678"  class="form-control" name="phone" required autofocus>

                            </div>
                        </div>
                        <div class="form-group">
                            <label for="solution" class="col-md-4 control-label">Solución</label>

                            <div class="col-md-6">
                                <select class="form-control" name="solution" id="solution" value=''>
                                <option value="crm">CRM</option>
                                <option value="elearning">Elearning</option>
                                <option value="hrm">Capital Humano</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group ">
                            <label for="agree" class="control-label col-md-10">Acepta políticas de privacidad y términos de uso *</label>
                            <div class="col-md-2">
                                <input type="checkbox" style="width: 16px" class="checkbox form-control" id="agree" name="agree" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn "  >
                                    Inicia 
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
