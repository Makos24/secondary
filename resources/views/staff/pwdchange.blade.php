@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Change Password</div>
                    <div class="panel-body">
<form method="post" class="form-horizontal" name="staffpwd" action="{{url('/staff/pwdchange')}}">
    {{csrf_field()}}
    <input name="id" type="hidden" value="{{Auth::user()->id}}">
    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
        <label for="old_password" class="col-md-4 control-label">Old Password</label>

        <div class="col-md-6">
            <input id="old_password" type="password" class="form-control" name="old_password" >

            @if ($errors->has('old_password'))
                <span class="help-block">
                                        <strong>{{ $errors->first('old_password') }}</strong>
                                    </span>
            @endif
        </div>
    </div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
    <label for="password" class="col-md-4 control-label">New Password</label>

    <div class="col-md-6">
        <input id="password" type="password" class="form-control" name="password" >

        @if ($errors->has('password'))
            <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
        @endif
    </div>
</div>

<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

    <div class="col-md-6">
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" >

        @if ($errors->has('password_confirmation'))
            <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
        @endif
    </div>
    </div>
    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-btn"></i> Update Password
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
