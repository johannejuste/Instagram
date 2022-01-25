<?php
// ######### TOP
require_once(__DIR__.'/view_top_profile.php');


// ########### VALIDATION user ######################
if( ! isset($_SESSION) ){ session_start(); }

if( ! isset( $_SESSION['user_uuid'] ) ){
  header('Location: /login');
  exit();  
}


// ########### ERROR / UPDATE MESSAGES ######################
  ?>
<div style="display: none;" class="error_message"></div>
<div style="display: none;" class="update_message"></div>
<?php





// ########### SHOW POSTS ###########################

require_once($_SERVER['DOCUMENT_ROOT'].'/db/db_assoc.php');
try{
  $q = $db->prepare('SELECT users.user_name, users.user_last_name, users.user_profile_picture, posts.post_uuid, 
  posts.post_image, posts.post_text, posts.post_date_time, posts.post_likes FROM posts JOIN users 
  ON posts.user_uuid = users.user_uuid ORDER BY posts.post_date_time DESC;
  ');
  $q->execute();
  $posts = $q->fetchAll();



  
// -------- Create post ---------->
?>
<div class="home_container">
  <div class="post_section_container">
    <div class="create_post">

      <div class="media status_box">
        <div class="flex">
          <div class="media_left">
            <img src="<?= $_SESSION['profile_picture']?>" alt="profile picture">
          </div>

          <form id="frm" onsubmit="uploadForm(); return false" autocomplete="off">
            <div class="media_body">
              <textarea type="text" name="new_post_text" placeholder="What's on your mind?" rows="4"
                cols="50"></textarea>
            </div>
        </div>

        <div>
          <div>
            <label for="upload_image">
              <div id="image_container"></div>
              <input class="display_none" type="file" name="fileToUpload" id="upload_image" onchange="showFile()"
                accept="image/*">
              <span id="camera_icon"></span>
            </label>

          </div>
          <button class="btn">Submit</button>
        </div>
        </form>
      </div>

    </div>
    <?php
// -------- End of create post ---------->




// -------- post feed ---------->
  foreach($posts as $post){
  ?>

    <div class="hidden">
      <svg id="dots" viewBox="0 0 48 48">
        <circle clip-rule="evenodd" cx="8" cy="24" fill-rule="evenodd" r="4.5"></circle>
        <circle clip-rule="evenodd" cx="24" cy="24" fill-rule="evenodd" r="4.5"></circle>
        <circle clip-rule="evenodd" cx="40" cy="24" fill-rule="evenodd" r="4.5"></circle>
      </svg>

      <svg id="like" viewBox="0 0 48 48">
        <path
          d="M34.6 6.1c5.7 0 10.4 5.2 10.4 11.5 0 6.8-5.9 11-11.5 16S25 41.3 24 41.9c-1.1-.7-4.7-4-9.5-8.3-5.7-5-11.5-9.2-11.5-16C3 11.3 7.7 6.1 13.4 6.1c4.2 0 6.5 2 8.1 4.3 1.9 2.6 2.2 3.9 2.5 3.9.3 0 .6-1.3 2.5-3.9 1.6-2.3 3.9-4.3 8.1-4.3m0-3c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5.6 0 1.1-.2 1.6-.5 1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z">
        </path>
      </svg>

      <svg id="dislike" viewBox="0 0 48 48">
        <path
          d="M34.6 3.1c-4.5 0-7.9 1.8-10.6 5.6-2.7-3.7-6.1-5.5-10.6-5.5C6 3.1 0 9.6 0 17.6c0 7.3 5.4 12 10.6 16.5.6.5 1.3 1.1 1.9 1.7l2.3 2c4.4 3.9 6.6 5.9 7.6 6.5.5.3 1.1.5 1.6.5s1.1-.2 1.6-.5c1-.6 2.8-2.2 7.8-6.8l2-1.8c.7-.6 1.3-1.2 2-1.7C42.7 29.6 48 25 48 17.6c0-8-6-14.5-13.4-14.5z">
        </path>
      </svg>
      <svg id="comment" viewBox="0 0 48 48">
        <path clip-rule="evenodd"
          d="M47.5 46.1l-2.8-11c1.8-3.3 2.8-7.1 2.8-11.1C47.5 11 37 .5 24 .5S.5 11 .5 24 11 47.5 24 47.5c4 0 7.8-1 11.1-2.8l11 2.8c.8.2 1.6-.6 1.4-1.4zm-3-22.1c0 4-1 7-2.6 10-.2.4-.3.9-.2 1.4l2.1 8.4-8.3-2.1c-.5-.1-1-.1-1.4.2-1.8 1-5.2 2.6-10 2.6-11.4 0-20.6-9.2-20.6-20.5S12.7 3.5 24 3.5 44.5 12.7 44.5 24z"
          fill-rule="evenodd"></path>
      </svg>

      <svg id="send" viewBox="0 0 48 48">
        <path
          d="M47.8 3.8c-.3-.5-.8-.8-1.3-.8h-45C.9 3.1.3 3.5.1 4S0 5.2.4 5.7l15.9 15.6 5.5 22.6c.1.6.6 1 1.2 1.1h.2c.5 0 1-.3 1.3-.7l23.2-39c.4-.4.4-1 .1-1.5zM5.2 6.1h35.5L18 18.7 5.2 6.1zm18.7 33.6l-4.4-18.4L42.4 8.6 23.9 39.7z">
        </path>
      </svg>

      <svg id="save" viewBox="0 0 48 48">
        <path
          d="M43.5 48c-.4 0-.8-.2-1.1-.4L24 29 5.6 47.6c-.4.4-1.1.6-1.6.3-.6-.2-1-.8-1-1.4v-45C3 .7 3.7 0 4.5 0h39c.8 0 1.5.7 1.5 1.5v45c0 .6-.4 1.2-.9 1.4-.2.1-.4.1-.6.1zM24 26c.8 0 1.6.3 2.2.9l15.8 16V3H6v39.9l15.8-16c.6-.6 1.4-.9 2.2-.9z">
        </path>
      </svg>
    </div>




    <div class="instapost_container">
      <div class="extra_collumn"></div>

      <div class="instapost" id="<?= $post['post_uuid']?>">

        <header class="instapost_header">
          <img class="instapost_profile_img" style="width: 50px;" src="<?= $post['user_profile_picture']?>"
            alt="profile picture">
          <div class="instapost_profile_name"> <?= $post['user_name'], $post['user_last_name']?></div>
        </header>

        <div class="instapost_image">
          <img style="width: 100px;" src="<?= $post['post_image']?>" alt="post_image">
        </div>

        <section class="instapost_action">

          <button class="instapost_btn btn-like like" onclick="like(); return false">
            <svg class="like_icon">
              <use xlink:href="#like" /></svg>
          </button>

          <button class="instapost_btn dislike hide" onclick="dislike(); return false">
            <svg class="dislike_icon">
              <use xlink:href="#dislike" /></svg>
          </button>

          <button class="instapost_btn btn-comment">
            <svg>
              <use xlink:href="#comment" />
            </svg></button>
          <button class="instapost_btn btn-send">
            <svg>
              <use xlink:href="#send" />
            </svg></button>
          <button class="instapost_btn btn_save">
            <svg>
              <use xlink:href="#save" />
            </svg></button>
        </section>

        <div class="instapost_picture_text">
          <div> <span data-like_id="<?=$post['post_uuid']?>"><?= $post['post_likes']?> </span> likes </div>
          <b> <?= $post['user_name'], $post['user_last_name'] ?> </b> <?= $post['post_text'] ?>
          <div class="link_to_page"> <?= date("F j Y, H:i", strtotime($post['post_date_time']))?></div>
        </div>
      </div>

      <div class="extra_collumn"></div>

    </div>
    <?php
// -------- end of post feed ---------->

  }
}catch(PDOException $ex){
  echo 'Oops, something went wrong';
}



// -------- users list ---------->
try{
  $q = $db->prepare('SELECT * FROM users WHERE user_admin = 0 AND user_status = 1');
  $q->execute();
  $users = $q->fetchAll();
  
  ?>
  </div>

  <div class="users_container_home">

    <div class="profile_homepage">
      <img class="instapost_profile_img_md" src="<?= $_SESSION['profile_picture']?>" alt="profile picture">
      <h2 class="heading"><?=$_SESSION['user_name']?> <?=$_SESSION['user_last_name']?> </h2>
    </div>

    <div class="users_homepage">
      <h2 class="heading">Suggestions for you</h2>
      <?php
  foreach($users as $user){
    unset($user['user_password']);
  ?>
      <div class="users">
        <div class="user_info">
          <img class="instapost_profile_img" src="<?= $user['user_profile_picture']?>" alt="profile_picture">
        </div>

        <div class="user_info">
          <div> <?= $user['user_name'] ?> <?= $user['user_last_name'] ?></div>
        </div>
      </div>
      <?php
  }
  ?>
    </div>
  </div>
</div>
<?php

  // -------- end of users list ---------->

}catch(PDOException $ex){
  echo 'Oops, something went wrong';
}




// ########### JS FETCH post and show image #################
?>

<script>
  async function like() {
    let button = event.target
    let button_parent = button.parentNode.parentNode.parentNode
    post_id = button_parent.id
    console.log(post_id);
    let conn = await fetch(`/posts/${post_id}/1`, {
      method: "POST"
    })
    // if( conn.status != 200 ){ alert("something went wrong") }
    if (!conn.ok) {
      alert("error");
      return
    }
    let response = await conn.text()
    console.log(response);

    button_parent.querySelector(".like").classList.add('hide')
    button_parent.querySelector(".dislike").classList.remove('hide')

    const like = document.querySelector(`[data-like_id="${post_id}"]`)
    like.textContent = parseInt(like.textContent) + 1

  }


  async function dislike() {
    let button = event.target
    let button_parent = button.parentNode.parentNode.parentNode.parentNode
    post_id = button_parent.id
    console.log(button_parent);
    let conn = await fetch(`/posts/${post_id}/0`, {
      method: "POST"
    })
    // if( conn.status != 200 ){ alert("something went wrong") }
    if (!conn.ok) {
      alert("error");
      return
    }
    let response = await conn.text()
    console.log(response);

    button_parent.querySelector(".dislike").classList.add('hide')
    button_parent.querySelector(".like").classList.remove('hide')

    const like = document.querySelector(`[data-like_id="${post_id}"]`)
    like.textContent = parseInt(like.textContent) - 1
  }



  async function uploadForm() {
    let conn = await fetch('/create-post', {
      method: "POST",
      body: new FormData(document.querySelector("#frm")),
      redirect: "manual",
      accepts: 'application/json; charset=utf-8' // designates the content to be in JSON format, encoded in the UTF-8 character encoding
    })
    if (!conn.ok) {
      let response = await conn.text()
      document.querySelector(".error_message").style.display = "block";
      document.querySelector(".error_message").innerHTML = response;

    } else {
      let response = await conn.json(); // read and parse the data
      console.log(response);
      document.querySelector(".error_message").style.display = "none";
      document.querySelector(".update_message").style.display = "block";
      document.querySelector(".update_message").innerHTML = "You created a post";



      const instapost = `
      <div class="instapost" id="${response.post_uuid}">

        <header class="instapost_header">
          <img class="instapost_profile_img" style="width: 50px;" src="${response.user_profile_picture}"
          alt="profile picture">
          <div class="instapost_profile_name"> ${response.user_name}${response.user_last_name}</div>
        </header>

        <div class="instapost_image">
         <img style="width: 100px;" src="${response.post_image}" alt="post_image">
        </div>

        <section class="instapost_action">
          <button class="instapost_btn btn-like like"onclick="like(); return false">
            <svg class="like_icon"><use xlink:href="#like" /></svg>
          </button>

          <button class="instapost_btn btn-comment">
            <svg><use xlink:href="#comment" /></svg>
          </button>

          <button class="instapost_btn btn-send">
            <svg><use xlink:href="#send" /> </svg>
          </button>

          <button class="instapost_btn btn_save">
            <svg><use xlink:href="#save" /></svg></button>
          </section>

        <div class="instapost_picture_text">
          <div> <span data-like_id="${response.post_uuid}">${response.post_likes} </span> likes </div>
          <b> ${response.user_name}, ${response.user_last_name} </b> ${response.post_text}
          <div class="link_to_page"> ${response.post_date_time}</div>
        </div>

      </div>`

      //parses the instapost text as HTML and inserts the resulting nodes into the DOM in .instapost_container
      document.querySelector(".instapost_container").insertAdjacentHTML("afterbegin", instapost)

      // removes thumbnail after creating post
      document.querySelector('#image_container').innerHTML = "";

      // removes text after creating post
      document.querySelector('.media_body').querySelector('textarea').value = "";

    }

  }

  // Check for the various File API support.
  function showFile() {
    console.log(event.target)
    let container = document.querySelector('#image_container');
    let thumbnail = new Image()
    thumbnail.width = "150"
    thumbnail.height = "150"
    container.insertAdjacentElement('beforeend', thumbnail)
    var demoImage = document.querySelector('fileToUpload');
    var file = document.querySelector('input[type=file]').files[0];
    var reader = new FileReader();
    reader.onload = function () {
      // console.log(event.target)
      // demoImage.src = reader.result;
      thumbnail.src = reader.result;
    }
    reader.readAsDataURL(file);
    // console.log(file)
  }
</script>





<?php
// ######### BOTTOM
require_once($_SERVER['DOCUMENT_ROOT'].'/views/view_bottom.php');
?>