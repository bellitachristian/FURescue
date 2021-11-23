<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('Profile/petowner/'.$petowner->id)}}">
    <div class="sidebar-brand-icon">
        <i class="fas fa-laugh-wink"></i>
    </div>
    <div class="sidebar-brand-text mx-3">{{ $LoggedUserInfo['fname']}} {{ $LoggedUserInfo['lname']}}</div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="/pet-owner/dashboard">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Role: Pet Owner
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
        aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Managements</span>
    </a>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Functions:</h6>
            <a class="collapse-item" href="{{url('Profile/petowner/'.$petowner->id)}}">Profile</a>
            <a class="collapse-item" href="{{route('pet.view')}}">Pets</a>
            <a class="collapse-item" href="{{route('selection.view.petowner')}}">Custom Selection</a>
        </div>
    </div>
</li>

<!-- Nav Item - Utilities Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
        aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-home"></i>
        <span>Adoption</span>
    </a>
    <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Adoption:</h6>
            <a class="collapse-item" href="{{route('view.policy')}}">Adoption Policy</a>
            <a class="collapse-item" href="{{route('adoption.request.petowner')}}">Approve/Reject</a>
            <a class="collapse-item" href="#">Request for Adoption</a>
        </div>
    </div>
</li>
<!-- Nav Item - Pages Collapse Menu -->

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-paw"></i>
        <span>Pet Book</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Facilities</h6>
            <a class="collapse-item" href="{{route('petbook.view.petowner')}}">View Book</a>
            <a class="collapse-item" href="{{route('allocate.view')}}">Allocation</a>
        </div>
    </div>
</li>


<li class="nav-item">
    <a class="nav-link" href="{{route('vaccine.deworm.view')}}">
        <i class="fas fa-fw fa-syringe"></i>
        <span>Vaccine & Deworm</span></a>
</li>

<li class="nav-item">
    <a class="nav-link" href="{{route('post.view.petowner')}}">
        <i class="fas fa-fw fa-newspaper"></i>
        <span>Post Pet</span></a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="#">
        <i class="fas fa-fw fa-table"></i>
        <span>Reports</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->