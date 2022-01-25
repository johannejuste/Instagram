<?php
// ######### TOP
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');
?>


<div class="container vertical_center">
<div class="input_section width_input_section">
<h1 class="heading">Email has been sent! </h1>
<p class="subheading">Please check your inbox and click in the recieved link to reset the password</p>

<form class="container_form" action="/login" method="GET">
    <button class="btn">Login</button>
  </form>

  <div style="margin-top: 5%;">
  <p>Didn't reseive the link? <a class="link_to_page_blue" href="/reset-password-with-email"> Resend</a></p>
  </div>

</div>
</div>


  <?php
  // ######### BOTTOM
  require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');