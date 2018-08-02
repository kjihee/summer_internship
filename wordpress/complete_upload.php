<?php /* Template Name: complete */ ?>
<?php
 $uploeaddir = "http://192.168.10.190:/var/www/html/wp-content/uploads/";
 $uploadfile = $uploaddir . basename($_FILES['file'] ['name']);
 $allowedExts = array("jpg", "jpeg", "gif", "png", "mp3", "mp4", "wma");
 $extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
 if ((($_FILES["file"]["type"] == "video/mp4")
|| ($_FILES["file"]["type"] == "audio/mp3")
|| ($_FILES["file"]["type"] == "audio/wma")
|| ($_FILES["file"]["type"] == "image/pjpeg")
|| ($_FILES["file"]["type"] == "image/png")
|| ($_FILES["file"]["type"] == "image/jpeg"))

&& ($_FILES["file"]["size"] < 20000)
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
?>
