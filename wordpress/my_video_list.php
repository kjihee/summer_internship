[insert_php]
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
$stmt = $db->prepare("SELECT * FROM wp_uploaded_video WHERE author =:user_id AND NOT status ='delete'");
$stmt->execute(array(':user_id' =>  $user_id));
$result = $stmt->fetchAll();
$row_count = $stmt->rowCount();
$units = explode(' ','  B KB MB GB TB PB');
 function format_size($size) {

        $mod = 1024;
        $units = explode(' ','B KB MB GB TB PB');
        for ($i = 0; $size > $mod; $i++) {
            $size /= $mod;
        }

        $endIndex = strpos($size, ".")+3;

        return substr( $size, 0, $endIndex).' '.$units[$i];
    }

echo '<table>';
  echo '<tr>';
    echo '<td> thumbnail </td>';
    echo '<td> title </td>';
    echo '<td> size </td>';
    echo '<td> uploaded_time </td>';
    echo '<td> type </td>';
    echo '<td> delete </td>';
    echo '</tr>';    
foreach ($result as $key => $val )   {
      $video_id = $val[0];
      $title = $val[1];
      $path_without_title = explode(".",$val[2]);
      $thumb_nail_path = explode("html/",$path_without_title[0]);
      echo '<tr>';
      echo "<td><img src='http://localhost/".  $thumb_nail_path[1]. ".png'/></td>";
      echo '<td>' . $val[1].'</td>';
      echo '<td>' . format_size($val[3]).'</td>';
      echo '<td>' . $val[5].'</td>';
      echo '<td>' . $val[6].'</td>';
      echo '<td><a name="'.$video_id.'" href="http://localhost/update_video_status.php?video_id='.$video_id.'">delete</a></td>';
      echo '</tr>';
    }
echo '</table>';


[/insert_php]
