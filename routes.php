<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/router.php');

// ##############################
get('/', 'views/view_home.php');
get('/error/$error_message', 'views/view_home.php');

get('/friends', 'views/view_friends.php');

get('/login', 'views/view_login.php');
get('/login/error/$error_message', 'views/view_login.php');
get('/login/update/$update_message', 'views/view_login.php');
get('/logout', 'bridges/bridge_logout.php');

get('/profile', 'views/view_profile.php');
get('/profile/edit', 'views/view_profile_edit.php');
get('/profile/edit/$update_message', 'views/view_profile_edit.php');
get('/profile/edit/$error_message', 'views/view_profile_edit.php');


// -- reset password
get('/reset-password-with-email', 'views/reset_password/view_reset_password_with_email.php');
get('/reset-password-with-email/error/$error_message', 'views/reset_password/view_reset_password_with_email.php');
get('/reset-password-with-email/update/$update_message', 'views/reset_password/view_reset_password_with_email.php');

get('/reset-password-email-sent', '/views/reset_password/view_reset_password_email_sent.php');

get('/reset-password/$user_id', '/views/reset_password/view_reset_password_create.php');
get('/reset-password/error/$error_message', '/views/reset_password/view_reset_password_create.php');

get('/reset-password-success/$user_id', 'views/reset_password/view_reset_password_success.php');

// -- signup
get('/signup', 'views/view_signup.php');
get('/signup/update/$update_message', 'views/view_signup.php');
get('/signup/error/$error_message', 'views/view_signup.php');
get('/verify/$user_id', '/bridges/bridge_verify_user.php');
get('/verify-success/$user_id', '/views/view_verify_success.php');

get('/users', 'views/view_users.php');


// get('/search', 'views/view_search.php');
// ##############################
// ##############################
// ##############################¨

post('/check-email-availible', 'apis/api_check_email.php');

post('/create-post', 'bridges/bridge_create_post.php');

post('/delete-account', 'bridges/bridge_delete_account.php');

post('/login', 'bridges/bridge_login.php');

post('/posts/$post_id/$like_or_dislike', 'apis/api_posts_like_or_dislike.php');

post('/profile/edit/details', 'bridges/bridge_edit_profile_details.php');
post('/profile/edit/password', 'bridges/bridge_edit_profile_password.php');

post('/reset-password-with-email', 'bridges/bridge_reset_password_send_email.php');
post('/reset-password', 'bridges/bridge_reset_password_update.php');

post('/signup', 'bridges/bridge_signup.php');

post('/upload-profile-picture', 'apis/api_upload_profile_picture.php');

post('/users/delete/$user_id', 'apis/api_delete_user.php');

// post('/search', 'apis/api-search.php');
// ##############################
// ##############################
// ##############################¨

any('/404', 'views/view_404.php');
