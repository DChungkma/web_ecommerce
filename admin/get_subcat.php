<?php
include('include/config.php');
if(!empty($_POST["cat_id"])) 
{
 $id=intval($_POST['cat_id']);
$query=mysqli_query($con,"SELECT * FROM subcategory WHERE categoryid=$id");
?>
<option value="">Select Subcategory</option>
<?php
 while($row=mysqli_fetch_array($query))
 {
  ?>
  <option value="<?php echo htmlentities($row['id']); ?>"><?php 
  //Test decryption
$key='qkwjdiw239&&jdafweihbrhnan&^%$ggdnawhd4njshjwuuO';
$encryption_key = base64_decode($key);
list($encrypted_data, $iv) = array_pad(explode('::', base64_decode($row['subcategory']), 2),2,null);
$row['subcategory'] = openssl_decrypt($encrypted_data, 'aes-256-cbc', $encryption_key, 0, $iv);
  
  echo htmlentities($row['subcategory']); ?></option>
  <?php
 }
}
?>