<?php
// Initialize the session
session_start();

// Check if the user is not logged in, if yes then redirect him to index page
if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)){
	header("Refresh: 3; url=index.php");
	die("<h2 style='color:red; text-align:center; margin-top:100px;'> 
         ⚠️ 請不要偷溜進來或執行操作！請乖乖登入... 系統將在 3 秒後自動跳轉。
         </h2>"); /*因為die會作廢下面的程式碼自然讀不到CSS所以必須寫上去*/
}
?>

<?php
include_once 'dbconfig.php';
if(isset($_GET['edit_id']))
{
 $sql_query="SELECT * FROM stock_list WHERE stock_id=".$_GET['edit_id'];
 $result_set=mysqli_query($link, $sql_query);
  $fetched_row=mysqli_fetch_array($result_set);
}
if(isset($_POST['btn-update']))
{
 // variables for input data
	$stock_code = $_POST['stock_code'];
	$stock_name = $_POST['stock_name'];
	$current_price = $_POST['current_price'];
	$category = $_POST['category'];
	$update_time = $_POST['update_time'];
 // variables for input data
 
 // sql query for update data into database
 $sql_query = "UPDATE stock_list SET stock_code='$stock_code',stock_name='$stock_name',current_price='$current_price',category='$category',update_time='$update_time' WHERE stock_id=".$_GET['edit_id'];
        
 // sql query for update data into database 
 // sql query execution function
 if(mysqli_query($link, $sql_query))
 {
  ?>
  <script type="text/javascript">
  alert('Data Are Updated Successfully');
  window.location.href='main.php';
  </script>
  <?php
 }
 else
 {
  ?>
  <script type="text/javascript">
  alert('error occured while updating data');
  </script>
  <?php
 }
}
 // sql query execution function
 if(isset($_POST['btn-cancel']))
 {
	header("Location: main.php");
 }

?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta charset="UTF-8"/>
<title>StockTrack - Portfolio Management System</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>


<?php include_once "header.php"?>

<div id="main">
 <div id="content">
    <form method="post">
    <table class="w3-table-all w3-hoverable w3-card-4 stock-table">
		<tr>
		<td><input type="text" name="stock_code" placeholder="代碼" value="<?php echo $fetched_row['stock_code']; ?>" required /></td>
		</tr>
		<tr>
		<td><input type="text" name="stock_name" placeholder="名字" value="<?php echo $fetched_row['stock_name']; ?>" required /></td>
		</tr>
		<tr>
		<td><input type="number" name="current_price" placeholder="現在價格" step="0.01" value="<?php echo $fetched_row['current_price']; ?>" required /></td>
		</tr>
		
		<tr>
		<td><input type="text" name="category" placeholder="行業別" value="<?php echo $fetched_row['category']; ?>" required /></td>
		</tr>
		
		<tr>
		<td><input type="date" name="update_time" value="<?php echo $fetched_row['update_time']; ?>" required /></td>
		</tr>
		
		<tr>
		<td>
		<button type="submit" name="btn-update"><strong>UPDATE</strong></button>
		<button type="submit" name="btn-cancel"><strong>Cancel</strong></button>
		</td>
		</tr>
    </table>
    </form>
 </div>
</div>
<?php include_once "footer.php"?>
</body>
</html>