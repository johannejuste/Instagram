<?php
// ######### TOP
require_once(__DIR__.'/view_top.php');
?>

<div class="container vertical_center">
<div class="input_section width_input_section">
<h1 class="heading">Your account is active!</h1>
<p class="subheading">(You will be redirected to login in 5 sec)</p>


<form class="container_form" action="/login" method="GET">
    <button class="btn">Login</button>
  </form>

</div>
</div>

<meta http-equiv="refresh" content="5;url=http://localhost:8888/login">

<?php
  require_once(__DIR__.'/view_bottom.php');