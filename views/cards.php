/**
 * Created by PhpStorm.
 * User: julius
 * Date: 08/01/2019
 * Time: 13:27
 */

<!-- Rooms count -->
<div class="card">
    <div class="card-header">
        Rooms
    </div>
    <div class="card-body">
        <p class="count">Our Platform already has</p>
        <h2><?= $room_count ?></h2>
        <p>rooms</p>
<a href="/DDWT18_G09/addrooms/" class="btn btn-primary">Add your room</a>
</div>

<div class="card-header">
    Users
</div>
<div class="card-body">
    <p class="count">We currently have</p>
    <h2><?= $student_count ?></h2>
    <p>students looking for a room</p>
    <a href="/DDWT18_G09/register/" class="btn btn-primary">Register if you are also looking</a>
</div>
</div>