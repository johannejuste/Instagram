<?php
// ######### TOP
require_once(__DIR__.'/view_top.php');

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


<div class="container vertical_center_sm">

<div>
<div class="input_section">
  <img class="logo" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Instagram_logo.svg/1200px-Instagram_logo.svg.png" alt="">
<p class="subheading">Please fill in this form to create an account.</p>
<form class="container_form" action="/signup" method="POST" onsubmit="return validate()" autocomplete="off">
<input type="text" name="new_user_name" placeholder="name" maxlength="20" data-validate="str" data-min="2" data-max="20" >
<input type="text" name="new_user_lastname" placeholder="lastname" maxlength="20" data-validate="str" data-min="2" data-max="20">
<label for="email" id="label_email"></label>
<input type="text" id="email" name="new_user_email" placeholder="email" data-validate="email" oninput="check_email()">
<input type="text" name="new_user_phone" placeholder="phone nr" data-validate="phone" maxlength="8">
<input type="password" name="new_user_password" placeholder="password" maxlength="50"
    data-validate="str" data-min="2" data-max="50">
<input type="password" name="new_user_confirm_password" placeholder="confirm password" maxlength="50"
    data-validate="match" data-match-name="new_user_password">
<button class="btn">Submit</button>
</form>
</div>

<div class="extra_section">
  <p>Do have an account? <a class="link_to_page_blue" href="/login"> Login</a></p>
</div>


</div>
</div>

<!--  ######### CHECK EMAIL -->
<script>
var check_email_timer // used to stop the check_email_timer
  async function check_email(){
  if(check_email_timer){clearTimeout(check_email_timer)}
  if(event.target.value.length >= 5){
    check_email_timer = setTimeout( async function(){
  let formData = new FormData() // creates an empty FormData object
  formData.append('email', document.querySelector('[name="new_user_email"]').value); // add value to object
  let conn = await fetch('/check-email-availible', {
    method : "POST",
    body : formData
  })  
  
  if (! conn.ok){ 
    let email_message = 'email not avalible'
    document.getElementById("label_email").innerHTML = email_message;
  }

  if (conn.ok){ 
  let email_message = 'email available'
  document.getElementById("label_email").innerHTML = email_message;
  }
}, 1500 ) // want to wait
  }else{
  document.getElementById("label_email").innerHTML = "";
  }
  }
  
  </script>
<?php
// ######### BOTTOM
require_once(__DIR__.'/view_bottom.php');