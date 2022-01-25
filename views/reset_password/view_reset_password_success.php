<?php
// ######### TOP
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top_no_nav.php');
?>

<div class="container vertical_center">
<div class="input_section width_input_section">
<h1 class="heading">Success!</h1>
<p class="subheading">Your password has been reset successfully. You can now login to your account</p>


<form class="container_form" action="/login" method="GET">
    <button class="btn">Login</button>
  </form>

</div>
</div>

  <?php
  // ######### BOTTOM
  require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');