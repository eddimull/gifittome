@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <form class="form-horizontal">
        <fieldset>

        <!-- Form Name -->
        <legend>Phone Number</legend>

        <!-- Text input-->
        <div class="form-group">
          <label class="col-md-4 control-label" for="textinput">Phone Number</label>  
          <div class="col-md-4">
          <input id="phone" name="textinput"  type="tel" placeholder="placeholder" class="form-control input-md">
          @if(Auth::user()->verified)
            <span class="help-block">Verified: <i style="color:green" class="fa fa-thumbs-up fa-3"></i></span>
          @else
            <span class="help-block">Verified: <i style="color:red" class="fa fa-thumbs-down fa-3"></i></span>
          @endif
          </div>
        </div>


        @if(!Auth::user()->verified)
        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="verificationCode"></label>
          <div class="col-md-4">

            @if($verificationSent)
            <button id="verificationCode" name="verificationCode" value="1" class="btn btn-default" disabled>Verification message sent <i style="color:green" class="glyphicon glyphicon-ok"></i></button>
            @else
            <button id="verificationCode" name="verificationCode" value="1" class="btn btn-default">resend verification code</button>
            @endif
          </div>
        </div>
        @endif




        <!-- Button -->
        <div class="form-group">
          <label class="col-md-4 control-label" for="Submit"></label>
          <div class="col-md-4">
            <button id="Submit" name="Submit" class="btn btn-success">Submit</button>
          </div>
        </div>

        </fieldset>
        </form>

        @endsection
      </div>
    </div>
  </div>
</div>

@section('scripts')
  <script>
    $("#phone").intlTelInput("setNumber", "{{ Auth::user()->phoneNumber }}");
  </script>
@endsection
