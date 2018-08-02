<?php
$db = new PDO('mysql:host=localhost;dbname=wordpress;charset=utf8', 'root', 'inisoft6223');
foreach($_COOKIE as $key => $value)
{
   if(preg_match('/^wordpress_logged_/', $key))
   {
    global $loggin_cookie;
    $loggin_cookie =  $value;
    
        // You can access $value or create a new array based off these values
   }
}
$cookie_info = explode("|", $loggin_cookie);
$username =  $cookie_info[0];
$stmt = $db->prepare("SELECT ID FROM wp_users WHERE user_login=:user_name");
$stmt->execute(array(':user_name' =>  $username));
$user = $stmt->fetch();
$user_id = ($user["ID"]);
date_default_timezone_set("Asia/Seoul");
$time =  date("Y-m-d h:i:s");

$fileName = $_FILES["file1"]["name"]; // The file name
$fileTmpLoc = $_FILES["file1"]["tmp_name"]; // File in the PHP tmp folder
$fileType = $_FILES["file1"]["type"]; // The type of file it is
$fileSize = $_FILES["file1"]["size"]; // File size in bytes
$fileErrorMsg = $_FILES["file1"]["error"]; // 0 for false... and 1 for true
$fileDes = "/var/www/html/wp-content/uploads/$user_id/";
$uploadfile = $fileDes.basename($_FILES['file1']['name']);
$file_name_without_type = explode(".",$fileName);
if(!is_dir($fileDes)){
mkdir($fileDes);
echo "make fileDes <br /> ";

 if(move_uploaded_file($fileTmpLoc, "$fileDes/$fileName" )){
  $stmt = $db->prepare("INSERT INTO wp_uploaded_video(video_id, title, file_path, size, author, uploaded_time, type, status) VALUES(null, :title, :path, :size, :author, :uploaded_time, :type, :status)");
  $stmt->execute(array(':title' => $_FILES["file1"]["name"], ':path' => $uploadfile, ':size' => $_FILES["file1"]["size"] , ':author' => $user_id, ':uploaded_time' => $time, ':type' =>$_FILES["file1"]["type"], ':status' => 'uploaded'));
  $affected_rows = $stmt->rowCount();
  
  shell_exec("ffmpeg -t 00:00:05 -ss 00:00:05 -i $uploadfile -vcodec png -vframes 1 $fileDes/$file_name_without_type[0].png");
  echo "$fileName upload is complete1 <br /> " ;
 }

 else {
  echo "move_uploaded_file function failed1" ;
 }

}

else {
echo "fileDes already exists <br />";
if( file_exists($uploadfile)) {
 echo "fileName already exists <br />";
 echo "Change your file name <br />";
 exit();
}
else {
 echo "you can upload new file <br />"; // 여기까지 에러 안남 
 if(move_uploaded_file($fileTmpLoc, "$fileDes/$fileName")){
  $stmt = $db->prepare("INSERT INTO wp_uploaded_video(video_id, title, file_path, size, author, uploaded_time, type, status) VALUES(null, :title, :path, :size, :author, :uploaded_time, :type, :status)");
  $stmt->execute(array(':title' => $_FILES["file1"]["name"], ':path' => $uploadfile, ':size' => $_FILES["file1"]["size"] , ':author' => $user_id, ':uploaded_time' => $time, ':type' =>$_FILES["file1"]["type"], ':status' => 'uploaded'));
  $affected_rows = $stmt->rowCount();
  shell_exec("ffmpeg -t 00:00:05 -ss 00:00:05 -i $uploadfile -vcodec png -vframes 1 $fileDes/$file_name_without_type[0].png");
  echo $file_name_without_type[0];

  echo "$fileName upload is complete2 <br /> ";
 }
 else{
  echo "move_uploaded_file function failed2 <br /> ";
 }
}
}
?>
