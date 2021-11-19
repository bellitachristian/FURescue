
<h4> Good day {{$mail_data['shelter_name']}}!</h4>

<p>Your account has been reactivated</p>
<p>Please click below in order to 
proceed.</p>
<p>P.S After clicking, your account will automatically log out and try logging in again.</p>

<a href="{{route('auto.reactivation',$mail_data['shelter_id'])}}"><button type="button" class="btn btn-primary">Click here!</button></a>
<br>
<br>

Best regards,
<br>
furescue team