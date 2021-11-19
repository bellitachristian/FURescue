
<h4>Good day! {{$mail_data['petowner_name']}}</h4>

<p>The system has detected that your valid documents are invalid.</p>
<p>Please click below for confirmation.</p>
 
<a href="{{url('/Reject/petowner/'.$mail_data['petowner_id'])}}"><button type="button" class="btn btn-primary">Click here!</button></a>
<br>
<br>

Best regards,
<br>
furescue team