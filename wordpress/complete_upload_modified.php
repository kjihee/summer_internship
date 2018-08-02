[insert_php]


$db = new PDO('mysql:host=localhost;dbname=wordpress;charset=utf8', 'root', 'inisoft');



    $current_user = wp_get_current_user();
    /**
     * @example Safe usage: $current_user = wp_get_current_user();
     * if ( !($current_user instanceof WP_User) )
     *     return;
     */
   
    echo 'User ID: ' . $current_user->ID . '<br />';
$time = current_time( mysql, $gmt = 0 );
    echo "current time: " . $time . "<br />";
$uploaddir = "/var/www/html/wp-content/uploads/";
$uploadfile = $uploaddir . basename($_FILES['file'] ['name']);
$allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);


if ((($_FILES["file"]["type"] == "video/mp4")
|| ($_FILES["file"]["type"] == "audio/mp3")
|| ($_FILES["file"]["type"] == "audio/wma")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/jpg"))

&& ($_FILES["file"]["size"] < 20000000)
&& in_array($extension, $allowedExts))

 {
 if ($_FILES["file"]["error"] > 0)
   {
   echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
   }
 else
   {
   echo "Upload: " . $_FILES["file"]["name"] . "<br />";
   echo "Type: " . $_FILES["file"]["type"] . "<br />";
   echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
   echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
   
   $stmt = $db->prepare("INSERT INTO wp_uploaded_video(video_id, title, path, size, author, uploaded_time, type) VALUES(null, :title, :path, :size, :author, :uploaded_time, :type)");
   $stmt->execute(array(':title' => $_FILES["file"]["name"], ':path' => $uploadfile, ':size' => $_FILES["file"]["size"] , ':author' => $current_user->ID, ':uploaded_time' => $time, ':type' =>$_FILES["file"]["type"]));
   $affected_rows = $stmt->rowCount();
   if (file_exists($uploadfile))
     {
     echo $_FILES["file"]["name"] . " already exists. ";
     }
   else
     {
     move_uploaded_file($_FILES["file"]["tmp_name"], $uploadfile);
     echo "Stored in: " . $uploadfile ;

     }
   }
 }
else
 {
 echo "Invalid file";
 }
[/insert_php]
