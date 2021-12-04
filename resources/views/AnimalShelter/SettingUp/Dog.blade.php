<form action="{{route('doglife.stage')}}" method="POST">
    @csrf
<main style="margin-top:30px" class="grid">
    <label class="option_item">
    <input type="checkbox" readOnly name="dog[]" value="Puppy" class="checkbox">
    <div class="option_inner puppy">
        <img src="images/puppy.jpg" height="230" width="220" alt="Puppy">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Puppy</h2>
            <input type="text" hidden name="pup" value="0-5months old">
        <p style="color:black">Ranging 0-5 months old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" readOnly name="dog[]" value="Adolescent" class="checkbox">
    <div class="option_inner adolescent">
        <img src="images/adolescent.jpg" height="230" width="220"  alt="Adolescent">
        <div class="tickmark"></div> 
            <h2 style="color:black; font-weight:bold">Adolescent</h2>
            <input type="text" hidden name="adol" value="6months-2years old">
        <p style="color:black">Ranging 6 months - 2 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" readOnly name="dog[]" value="Adult" class="checkbox">
    <div class="option_inner adult">
        <img src="images/adult.jpg" height="230" width="220" alt="Adult">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Adult</h2>
            <input type="text" hidden name="adul" value="3-6years old">
        <p style="color:black">Ranging 3-6 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" readOnly name="dog[]" value="Senior" class="checkbox">
    <div class="option_inner puppy">
        <img src="images/senior.jpg" height="230" width="220"  alt="Senior">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Senior</h2>
            <input type="text" hidden name="sen" value="7-13years old">
        <p style="color:black">Ranging 7-13 years old</p>
    </div>
    </label>  
    <label></label>
    <div class="btn">
        <button style="margin-top:50%" type="submit">Proceed</button>
    </div>
</main>  
</form>

