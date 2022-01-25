<?php
// ######### TOP
require_once(__DIR__.'/view_top_no_nav.php');




// ######### UPDATE / ERROR MESSAGES
if( isset($update_message) ){ // isset() checks whether the variable is set/declared
  ?>
<div class="update_message">
  <?= urldecode($update_message) ?>
  <!-- urldecode accepts the parameter $show_error (that holds the URL) to be decoded (no wierd symbols/encoding ##%) the function returns the decoded string on succes -->
</div>
<?php
  }
?>
<?php
  if( isset($error_message) ){
    ?>
<div class="error_message">
  ERROR - <?= urldecode($error_message) ?>
</div>
<?php
    }
    ?>



<!-- // ######### LOGIN FORM ----->
<div class="container vertical_center">

<div id="frontpage_phones">
  <img src="/images/dev/frontpage-phones.png" alt="frontpage phones">
</div>

<div>
<div class="input_section">
  <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/1200px-Instagram_logo.svg.png" alt="">
<form class="container_form" action="/login" method="POST" onsubmit="return validate()" autocomplete="off">
 <input type="text" name="user_email" placeholder="email" data-validate="email">
  <input name="user_password" type="password" placeholder="password" maxlength="50" data-validate="str" data-min="2"
    data-max="50">
  <button class="btn">login</button>
</form>

<div class="separator">
    <div class="line"></div>
    <p>OR</p>
    <div class="line"></div>
  </div>

<form action="/reset-password-with-email" method="GET">
  <a class="link_to_page" href="/reset-password-with-email"> Forgot password?</a>
</form>
</div>

<div class="extra_section">
  <p>Don't have an account? <a class="link_to_page_blue" href="/signup"> Signup</a></p>
</div>
</div>

</div>


<?php
// ######### BOTTOM
  require_once(__DIR__.'/view_bottom.php');