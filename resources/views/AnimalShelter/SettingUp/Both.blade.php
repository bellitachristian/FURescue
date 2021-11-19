<form action="{{route('bothlife.stage')}}" method="POST">
@csrf
<div class="col-xl-1 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Dashboard header -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h5 style="color:black">Cats</h5>
        </div>
    </div>
</div>
<main style="margin-top:30px" class="grid">
    <label class="option_item">
    <input type="checkbox"  hidden name="cat[]" value="Kitten" class="checkbox">
    <div class="option_inner kitten">
        <img src="images/kitten.jpg" height="230" width="220" alt="Kitten">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Kitten</h2>
            <input type="text"  hidden name="kit" value="0-6months old">
        <p style="color:black">Ranging 0-6 months old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox"  hidden name="cat[]" value="Junior" class="checkbox">
    <div class="option_inner junior">
        <img src="images/junior.png" height="230" width="220"  alt="Junior">
        <div class="tickmark"></div> 
            <h2 style="color:black; font-weight:bold">Junior</h2>
            <input type="text"  hidden name="jun" value="7months-2years old">
        <p style="color:black">Ranging 7 months - 2 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" hidden name="cat[]" value="Prime" class="checkbox">
    <div class="option_inner prime">
        <img src="images/prime.jpg" height="230" width="220" alt="Prime">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Prime</h2>
            <input type="text"  hidden name="prim" value="3-6years old">
        <p style="color:black">Ranging 3-6 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" hidden name="cat[]" value="Mature" class="checkbox">
    <div class="option_inner mature">
        <img src="images/mature.jpg" height="230" width="220" alt="Mature">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Mature</h2>
            <input type="text"  hidden name="mat" value="7-10years old">
        <p style="color:black">Ranging 7-10 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" hidden name="cat[]" value="Senior" class="checkbox">
    <div class="option_inner seniorcat">
        <img src="images/seniorcat.jpg" height="230" width="220" alt="Senior">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Senior</h2>
            <input type="text"  hidden name="sen" value="11-14years old">
        <p style="color:black">Ranging 11-14 years old</p>
    </div>
    </label>  
</main>  
<div class="col-xl-1 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Dashboard header -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h5 style="color:black">Dogs</h5>
        </div>
    </div>
</div>  
<main style="margin-top:30px" class="grid">
    <label class="option_item">
    <input type="checkbox" hidden name="dog[]" value="Puppy" class="checkbox">
    <div class="option_inner puppy">
        <img src="images/puppy.jpg" height="230" width="220" alt="Puppy">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Puppy</h2>
            <input type="text"  hidden name="pup" value="0-5months old">
        <p style="color:black">Ranging 0-5 months old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" hidden name="dog[]" value="Adolescent" class="checkbox">
    <div class="option_inner adolescent">
        <img src="images/adolescent.jpg" height="230" width="220"  alt="Adolescent">
        <div class="tickmark"></div> 
            <h2 style="color:black; font-weight:bold">Adolescent</h2>
            <input type="text"  hidden name="adol" value="6months-2years old">
        <p style="color:black">Ranging 6 months - 2 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" hidden name="dog[]" value="Adult" class="checkbox">
    <div class="option_inner adult">
        <img src="images/adult.jpg" height="230" width="220" alt="Adult">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Adult</h2>
            <input type="text"  hidden name="adul" value="3-6years old">
        <p style="color:black">Ranging 3-6 years old</p>
    </div>
    </label>  
    <label class="option_item">
    <input type="checkbox" hidden name="dog[]" value="Senior" class="checkbox">
    <div class="option_inner puppy">
        <img src="images/senior.jpg" height="230" width="220"  alt="Senior">
        <div class="tickmark"></div>
            <h2 style="color:black; font-weight:bold">Senior</h2>
            <input type="text"  hidden name="sendog" value="7-13years old">
        <p style="color:black">Ranging 7-13 years old</p>
    </div>
    </label> 
    <label for=""></label>
    <div class="btn">
        <button type="submit" style="margin-top:50%">Proceed</button> 
    </div>
</main>  
</form>
