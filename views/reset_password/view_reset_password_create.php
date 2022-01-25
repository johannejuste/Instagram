<?php
// ######### TOP
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');

// ######### ERROR MESSAGES
  if( isset($error_message) ){ // isset() checks whether the variable is set/declared
    ?>
      <div class="error_message">
       ERROR <?= urldecode($error_message) ?> <!-- urldecode accepts the parameter $show_error (that holds the URL) to be decoded (no wierd symbols/encoding ##%) the function returns the decoded string on succes -->
      </div>
    <?php
    }
?>

<div class="container vertical_center">
<div class="input_section width_input_section">
<h1 class="heading" >Create new password</h1>
<p class="subheading">Please create a new password by filling in the form below</p>
<form class="container_form" action="/reset-password" method="POST" onsubmit="return validate()"  autocomplete="off">
<input type="hidden" name="user_id" value="<?= $user_id ?>">
<input type="password" name="new_reset_password" placeholder="Password" maxlength="50"
data-validate="str" data-min="2" data-max="50">
<input type="password" name="confirm_new_reset_password" placeholder="Confirm password" maxlength="50"
data-validate="match" data-match-name="new_reset_password">
<button class="btn">create</button>
</form>

</div>
</div>

<?php

   // ######### BOTTOM
   require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');