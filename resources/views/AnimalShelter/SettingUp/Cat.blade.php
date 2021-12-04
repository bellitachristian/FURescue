<form action="{{route('catlife.stage')}}" method="POST">
@csrf
<main style="margin-top:30px" class="grid">
    <label class="option_item">
    <input type="checkbox" readOnly name="cat[]" value="Kitten" class="checkbox">
    <div class="option_inner kitten">
        <img src="images/kitten.jpg" height="230" width="220" alt="Kitten">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Kitten</h2>
            <input type="text" hidden name="kit" value="0-6months old">
        <p style="color:black">Ranging 0-6 months old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" readOnly  name="cat[]" value="Junior" class="checkbox">
    <div class="option_inner junior">
        <img src="images/junior.png" height="230" width="220"  alt="Junior">
        <div class="tickmark"></div> 
            <h2 style="color:black; font-weight:bold">Junior</h2>
            <input type="text" hidden name="jun" value="7months-2years old">
        <p style="color:black">Ranging 7 months - 2 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" readOnly  name="cat[]" value="Prime" class="checkbox">
    <div class="option_inner prime">
        <img src="images/prime.jpg" height="230" width="220" alt="Prime">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Prime</h2>
            <input type="text" hidden name="prim" value="3-6years old">
        <p style="color:black">Ranging 3-6 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" readOnly  name="cat[]" value="Mature" class="checkbox">
    <div class="option_inner mature">
        <img src="images/mature.jpg" height="230" width="220" alt="Mature">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Mature</h2>
            <input type="text" hidden name="mat" value="7-10years old">
        <p style="color:black">Ranging 7-10 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" readOnly  name="cat[]" value="Senior" class="checkbox">
    <div class="option_inner seniorcat">
        <img src="images/seniorcat.jpg" height="230" width="220" alt="Senior">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Senior</h2>
            <input type="text" hidden name="sen" value="11-14years old">
        <p style="color:black">Ranging 11-14 years old</p>
    </div>
    </label>  
    <div class="btn">
    <button style="margin-top:50%" type="submit">Proceed</button>
    </div>
</main>  
</form>
