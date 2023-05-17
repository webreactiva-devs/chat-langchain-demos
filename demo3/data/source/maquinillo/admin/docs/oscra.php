<?
  if ($_POST["ppp"] == "1")
  {
$target = "upld/"; 
$target = $target . basename( $_FILES['uploaded']['name']) ; 
$ok=1; 
if(move_uploaded_file($_FILES['uploaded']['tmp_name'], $target)) 
{
echo "The file ". basename( $_FILES['uploadedfile']['name']). " has been uploaded";
} 
else {
echo "Sorry, there was a problem uploading your file.";
}
    exit();
  }
?>

<form enctype="multipart/form-data" method="POST">
Please choose a file: <input name="uploaded" type="file" /><br />
<input type="hidden" name="ppp" value="1">
<input type="submit" value="Upload" />
</form>