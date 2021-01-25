@extends('layouts.app')

@section('content')
<div class="container" style="min-height:480px">
<div class="row">
<div class="col-lg-5 col-md-offset-3">
<div class="panel panel-default">
    <div class="panel-heading"><h4>Select School Section</h4> </div>
    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/start') }}">
            {{ csrf_field() }}
            <input type="hidden" value="primary" name="section">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Primary Section">
        </form>
        <br>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/start') }}">
            {{ csrf_field() }}
            <input type="hidden" value="secondary" name="section">
            <input type="submit" class="btn btn-primary btn-lg btn-block" value="Secondary Section">
        </form>
    </div>
</div>
</div>
</div>
</div>
@endsection
