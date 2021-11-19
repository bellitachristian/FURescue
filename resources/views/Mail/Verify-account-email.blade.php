
<h4> Hello {{$mail_data['shelter_name']}} welcome to furescue!</h4>

<p>Please click below in order to 
verify your account.</p>

<a href="{{url('/verify?code='.$mail_data['verify'])}}"><button type="button" class="btn btn-primary">Click here!</button></a>
<br>
<br>

Best regards,
<br>
furescue team