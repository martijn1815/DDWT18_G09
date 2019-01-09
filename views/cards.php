<!-- Rooms count -->
<div class="card">
    <div class="card-header">
        Rooms
    </div>
    <div class="card-body">
        <p class="count">At the moment we have</p>
        <h2><?= $nbr_rooms ?></h2>
        <p>rooms available on our website</p>
        <a href="/DDWT18_G09/roomsoverview/" class="btn btn-primary">View the rooms</a>
    </div>
</div>
</br>
    <!-- Users count -->
<div class="card">
    <div class="card-header">
        Users
    </div>
    <div class="card-body">
        <p class="count">We currently have</p>
        <h2><?= $nbr_tenants ?></h2>
        <p>tenants looking for a room</p>
        <p><i>Also looking for a room?</i></p>
        <a href="/DDWT18_G09/register/" class="btn btn-primary">Register here</a>
    </div>
</div>