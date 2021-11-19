<form action="{{route('both.fee.petowner')}}" method="POST">
@csrf
<main style="margin-top:30px" class="grid">
    <label class="option_item">
    <input type="checkbox" name="fee[]" value="Free" class="checkbox">
    <div class="option_inner kitten">
        <img src="{{asset('images/dogs_cats.jpg')}}" style="height:300px"  alt="Kitten">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">FREE</h2>
            <input type="text" hidden name="kit" value="FREE">
        <p style="color:black">All cats and dogs for adoption are considered as FREE for Adopters.</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" id="checkfee"  name="fee[]" value="Default" class="checkbox">
    <div class="option_inner junior">
        <img src="https://wallpaperaccess.com/full/1122476.jpg" style="height:300px"   alt="Junior">
        <div class="tickmark"></div> 
            <h2 style="color:black; font-weight:bold">DEFAULT</h2>
            <input type="number" class="form-control" id="fee" required placeholder="Adoption Cat fee: P500.00" name="catfee">
            <input type="number" class="form-control" id="fees" required placeholder="Adoption Dog fee: P700.00" name="dogfee">
        <p style="color:black">Default adoption fee is customized as two fees, one for cats and the other is for dogs.</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox"  name="fee[]"value="Custom" class="checkbox">
    <div class="option_inner prime">
        <img src="https://i.pinimg.com/originals/26/98/bf/2698bfc861235f13ef276c7e7006b221.png"  style="height:300px"  alt="Prime">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">CUSTOM</h2>
        <p style="color:black">Custom adoption fee is applicable for customizing a desired fee for each cat and dog.</p>
    </div>
    </label>  
    <label for=""></label>
    <label for=""></label>
    <div class="btn">
    <button type="submit">Finish</button>
    </div>
</main>  
</form>


@push('js')
<script type="text/javascript">
document.getElementById("fee").style.display = "none";
document.getElementById("fees").style.display = "none";
$(document).on('click', '#checkfee', function(){
   if(this.checked){
       document.getElementById("fee").style.display = "block";
       document.getElementById("fees").style.display = "block";

   }
   else{
       document.getElementById("fee").style.display = "none";
       document.getElementById("fees").style.display = "none";
   }
 });

</script>
@endpush
