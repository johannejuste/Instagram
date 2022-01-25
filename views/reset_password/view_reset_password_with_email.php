<?php
// ######### TOP
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_top.php');

// ######### ERROR MESSAGES
  if( isset($error_message) ){ // isset() checks whether the variable is set/declared
    ?>
<div class="error_message">
  ERROR - <?= urldecode($error_message) ?>
  <!-- urldecode accepts the parameter $show_error (that holds the URL) to be decoded (no wierd symbols/encoding ##%) the function returns the decoded string on succes -->
</div>
<?php
    }
    ?>

<div class="container vertical_center">
<div class="input_section width_input_section">
  <h1 class="heading">Forgot your password? </h1>
  <p class="subheading">Enter the email associated with your account and we'll send an email with instructions to reset
    your password</p>

  <form class="container_form" action="/reset-password-with-email" method="POST" onsubmit="return validate()"  autocomplete="off">
    <input type="text" name="user_email" placeholder="email" data-validate="email">
    <button class="btn">Send login link</button>
  </form>

  <div class="separator">
    <div class="line"></div>
    <p>OR</p>
    <div class="line"></div>
  </div>

<a class="bold_p" href="/signup">Create an account</a>

<div style="margin-top: 5%;">
  <a class="link_to_page" href="/login">Back to login</a>
  </div>

</div>

</div>

<?php

  // ######### BOTTOM
  require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');