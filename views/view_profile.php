<?php
// ######### TOP
require_once(__DIR__.'/view_top_profile.php');



// ######### VALIDATION
if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /login');
  exit();  
}




// ############## SELECT USER #######################
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

  // ########## PROFILE PAGE
  ?>

<header>
<div class="profile_container">

<div class="profile">

<form id="frm">
<label for="upload_profile_picture">
    <input class="display_none" id="upload_profile_picture" type="file" name="fileToUpload" onchange="uploadForm()" accept="image/*">
    <div class="profile_image">
  <img id="profile_picture_update" src="<?=$user['user_profile_picture']?>" alt="Profile picture">
</div>
</label> 
</form>



<div class="profile_user_settings">
  
  <h1 class="profile_user_name"> <?=$user['user_name']?> <?=$user['user_last_name']?></h1>
  <form class="profile_edit_btn_form" action="/profile/edit" method="GET">
  <button  class="btn_profile profile_edit_btn">Edit profile</button>
</form>
<div class="dropdown">
  <button class="btn_profile profile_settings_btn dropbtn" onclick="open_dropdown()">⚙️</button>

  <div id="dropdown_settings" class="dropdown_content">
    <form action="/logout" method="GET">
      <button>Logout</button>
    </form>
    <form action="/delete-account" method="POST">
      <button>Delete profile</button>
      </form>


<?php 
    // ----- Button admin ----->

    if($_SESSION['user_admin'] == 1 ){
      ?> 
      <form action="/users" method="GET">
    <button>Manage users</button>
    </form>

    <?php
     // --- Button admin end ---->
    }?>

      </div>

</div>
</div>

<div class="profile_stats">
  <ul>
    <li><span class="profile_stat_count">164</span> posts</li>
    <li><span class="profile_stat_count">188</span> followers</li>
    <li><span class="profile_stat_count">206</span> following</li>
  </ul>
</div>

<div class="profile_bio">
  <p><span class="profile_real_name">Jane Doe</span> Lorem ipsum dolor sit, amet consectetur adipisicing elit 📷✈️🏕️</p>
</div>

  </div>
  </div>
</header>

<?php
    
  }catch(PDOException $ex){
    echo $ex;
  }


// ########## PROFILE POSTS
try{
$q = $db->prepare('SELECT posts.post_image FROM users JOIN posts ON posts.user_uuid = users.user_uuid WHERE users.user_uuid = :user_uuid ORDER BY posts.post_date_time DESC');
$q->bindValue(':user_uuid', $_SESSION['user_uuid']);
$q->execute();
$user_posts = $q->fetchAll();

?>
<div class="profile_container">
<div class="gallery">
  <?php
foreach($user_posts as $user_post){
?>
  <div class="user_posts">
  <img src="<?= $user_post['post_image']?>" alt="post_image">
</div>
<?php
}
?>
</div>
</div>
<?php
}catch(PDOException $ex){
  echo $ex;
}

?>


<!-- ########## SCRIPT post and image ############## -->
  <script>

    
/* When the user clicks on the button,
toggle between hiding and showing the dropdown content */
function open_dropdown() {
  document.getElementById("dropdown_settings").classList.toggle("show");
}

// Close the dropdown menu if the user clicks outside of it
window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown_content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains('show')) {
        openDropdown.classList.remove('show');
      }
    }
  }
}

  async function uploadForm(){
    let conn = await fetch('/upload-profile-picture', {
      method : "POST",
      body : new FormData(document.querySelector("#frm")),
      redirect : "manual"
    })
    if(!conn.ok){alert("error"); return}
    let response = await conn.text()
    console.log(response);
      document.querySelector("#profile_picture_update").setAttribute("src", response+ `?v=${new Date().getTime()}`) // random, newest time always newest image "new link" because of parameter
      document.querySelector(".instapost_profile_img").setAttribute("src", response+ `?v=${new Date().getTime()}`)

  }

  function open_upload_image() {
  var image_form = document.getElementById("frm");
  if (image_form.style.display === "none") {
    image_form.style.display = "block";
  } else {
    image_form.style.display = "none";
  }
}

  </script>
 
 <?php
  require_once(__DIR__.'/view_bottom.php');