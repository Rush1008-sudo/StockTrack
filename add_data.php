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
	if(isset($_POST['btn-save']))
	{
		// variables for input data
		$stock_code = $_POST['stock_code'];
		$stock_name = $_POST['stock_name'];
		$current_price = $_POST['current_price'];
		$category = $_POST['category'];
		$update_time = $_POST['update_time'];
		// variables for input data
 
		// sql query for inserting data into database
 
        $sql_query = "INSERT INTO stock_list(stock_code,stock_name,current_price,category,update_time) VALUES('$stock_code','$stock_name','$current_price','$category','$update_time')";
		mysqli_query($link, $sql_query);
        
        // sql query for inserting data into database
 
	}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta charset="UTF-8"/>
<title>StockTrack - Portfolio Management System</title>
<link rel="stylesheet" href="style.css?"/>
</head>
<body>

<?php include_once "header.php"?>
<div id="main">
 <div id="content">
    <form method="post">
		<table class="w3-table-all w3-hoverable w3-card-4 stock-table">
			<tr>
			<td align="center"><a href="main.php">back to main page</a></td>
			</tr>
			<tr>
			<td><input type="text" name="stock_code" placeholder="代碼" required /></td>
			</tr>
			<tr>
			<td><input type="text" name="stock_name" placeholder="名字" required /></td>
			</tr>
			<tr>
			<td><input type="number" name="current_price" placeholder="現在價格" step="0.01"required /></td>
			</tr>
			<tr>
			<td><input type="text" name="category" placeholder="行業別" required /></td>
			</tr>
			<tr>
			<td><input type="date" name="update_time"  required /></td>
			</tr>
			<tr>
			<td><button type="submit" name="btn-save"><strong>SAVE</strong></button></td>
			</tr>
		</table>
    </form>
 </div>
</div>


<?php include_once "footer.php"?>

</body>
</html>