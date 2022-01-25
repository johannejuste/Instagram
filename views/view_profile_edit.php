<?php
// ######### TOP
require_once(__DIR__.'/view_top_profile.php');



// ######### VALIDATION
if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /login');
  exit();  
}


// ##############################
// ##############################
// ##############################¨



// ############## EDIT PROFILE #######################
require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');

try{
  $q = $db->prepare('SELECT * FROM users WHERE user_uuid = :user_uuid');
  $q->bindValue(':user_uuid', $_SESSION['user_uuid']);
  $q->execute();
  $user = $q->fetch();
  if( ! $user ){
    header('Location: /login');
    exit();
  }

// ######### UPDATE / ERROR MESSAGES
  if( isset($update_message) ){ // isset() checks whether the variable is set/declared
    ?>
<div class="update_message">
  <?= urldecode($update_message) ?>
  <!-- urldecode accepts the parameter $show_error (that holds the URL) to be decoded (no wierd symbols/encoding ##%) the function returns the decoded string on succes -->
</div>
<?php
  }
  if( isset($error_message) ){ 
    ?>
<div class="error_message">
  ERROR <?= urldecode($error_message) ?>
</div>
<?php
    }



// ######### EDIT PROFILE DETAILS AND PASSWORD - HTML
  ?>

  <div class="edit_container">
<div class="tab">
  <button class="tablinks" id="defaultOpen" onclick="openEditTabs(event, 'edit_profile')">Edit profile</button>
  <button class="tablinks" onclick="openEditTabs(event, 'edit_password')">Change password</button>
</div>


<!------ Edit profile details  ------->
<div id="edit_profile" class="tabcontent">
  <div class="edit_profile_header">
<img class="instapost_profile_img" src="<?= $user['user_profile_picture']?>" alt="profile picture">
  <div class="profile_user_name"><?=$user['user_name']?> <?=$user['user_last_name']?> </div>
  </div>

  <form action="/profile/edit/details" method="POST" onsubmit="return validate()"
    autocomplete="off">
    <div class="row">
      <div class="col_25">
    <label for="edit_user_name">Name</label>
      </div>
      <div class="col_75">
    <input type="text" name="edit_user_name" placeholder="name" maxlength="20" data-validate="str" data-min="2"
    data-max="20" value="<?=$user['user_name']?>">
      </div>
    </div>
    <div class="row">
      <div class="col_25">
    <label for="edit_user_last_name">Last name</label>
      </div>
      <div class="col_75">
    <input type="text" name="edit_user_lastname" placeholder="lastname" maxlength="20" data-validate="str" data-min="2"
    data-max="20" value="<?=$user['user_last_name']?>">
      </div>
    </div>
    <div class="row">
      <div class="col_25">
    <label for="edit_user_email">Email</label>
      </div>
      <div class="col_75">
    <input type="text" id="email" name="edit_user_email" placeholder="email" data-validate="email"
      value="<?=$user['user_email']?>">
      </div>
    </div>
    <div class="row">
      <div class="col_25">
    <label for="edit_user_phone"> Phone</label>
      </div>
      <div class="col_75">
    <input type="text" name="edit_user_phone" placeholder="phone nr" data-validate="phone"
      value="<?=$user['user_phone']?>">
      <button style="width: 200px" class="btn">Save changes</button>
      </div>
    </div>
  </form>

</div>

<!------ Edit password  ------->
<div id="edit_password" class="tabcontent">
<img class="instapost_profile_img" src="<?= $user['user_profile_picture']?>" alt="profile picture">
  <div class="profile_user_name"><?=$user['user_name']?> <?=$user['user_last_name']?> </div>
  
  <form class="container_form" action="/profile/edit/password" method="POST" onsubmit="return validate()"
    autocomplete="off">
    <div class="row">
      <div class="col_25">
    <label for="current_user_password">Current password</label>
      </div>
      <div class="col_75">
    <input type="password" name="current_user_password" placeholder="Current password" maxlength="50"
      data-validate="str" data-min="2" data-max="50">
      </div>
    </div>
    <div class="row">
      <div class="col_25">
    <label for="edit_user_password">New password</label>
      </div>
      <div class="col_75">
    <input type="password" name="edit_user_password" placeholder="New password" maxlength="50"
      data-validate="str" data-min="2" data-max="50">
      </div>
    </div>
    <div class="row">
      <div class="col_25">
    <label for="edit_user_confirm_password">Confirm new password</label>
      </div>
      <div class="col_75">
    <input type="password" name="edit_user_confirm_password" placeholder="Confirm new password" maxlength="50"
      data-validate="match" data-match-name="edit_user_password">
      <button style="width: 200px" class="btn">Save changes</button>
      </div>
    </div>
  </form>
</div>
</div>

<?php
}catch(PDOException $ex){
    echo 'Oops, something went wrong'; 
  }
?>


<!-- ########## SCRIPT TABS ############## -->
<script>
  function openEditTabs(evt, editName) {
    // Declare all variables
    var i, tabcontent, tablinks;

    // Get all elements with class="tabcontent" and hide them
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(editName).style.display = "block";
    evt.currentTarget.className += " active";
  }

  // Get the element with id="defaultOpen" and click on it
  document.getElementById("defaultOpen").click();
</script>


<?php
  require_once(__DIR__.'/view_bottom.php');