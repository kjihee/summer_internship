<?php
function update_video_status($db, $video_id) {
  $affected_rows = $db->prepare("UPDATE wp_uploaded_video SET status='delete' WHERE video_id=:video_id");
  $affected_rows->execute(array(':video_id' =>  $video_id));
}

// find user_id using username from cookie
foreach($_COOKIE as $key => $value)
{
  if(preg_match('/^wordpress_logged_/', $key))
  {
    global $loggin_cookie;
    $loggin_cookie =  $value;
   }
}

$db = new PDO('mysql:host=localhost;dbname=wordpress;charset=utf8', 'root', 'ini6223');

$cookie_info = explode("|", $loggin_cookie);
$username =  $cookie_info[0];
$stmt = $db->prepare("SELECT ID FROM wp_users WHERE user_login=:user_name");
$stmt->execute(array(':user_name' =>  $username));
$user = $stmt->fetch();
$user_id = ($user["ID"]);

// get vidoe_id's author from DB
$video_id = $_GET['video_id'];

$stmt = $db->prepare("SELECT author FROM wp_uploaded_video WHERE video_id=:video_id");
$stmt->execute(array(':video_id' => $video_id));
$author = $stmt->fetch();
$author_id = ($author['author']);

// update video_id's status
if($user_id == $author_id){
update_video_status($db, $video_id);
header('Location: http://192.168.10.37/my_video_list/');
 }else{
echo "To Update Video Status is Failed";}
?>
