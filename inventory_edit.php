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
 $id = intval($_GET['edit_id']);
 $sql_query = "SELECT i.*, l.stock_code, l.stock_name, l.category 
               FROM stock_inventory i 
               INNER JOIN stock_list l ON i.stock_id = l.stock_id 
               WHERE i.inventory_id = " . $id;
               
 $result_set = mysqli_query($link, $sql_query);
 $fetched_row = mysqli_fetch_assoc($result_set);
}

if(isset($_POST['btn-update']))
{		
		//只給修改股數、平均成本
		$quantity = floatval($_POST['quantity']); 
		$avg_cost = floatval($_POST['avg_cost']); 
		//寫入資料表，市值與未實現損益交給inventory.php中進行計算
		$sql_query = "UPDATE stock_inventory  
                      SET quantity = $quantity, 
                          avg_cost = $avg_cost 
                      WHERE inventory_id = " . intval($_GET['edit_id']);
        
 // sql query execution function
 if(mysqli_query($link, $sql_query))
 {
  ?>
  <script type="text/javascript">
  alert('Data Are Updated Successfully');
  window.location.href='inventory.php';
  </script>
  <?php
 }
 else
 {
  ?>
  <script type="text/javascript">
  alert('error occured while updating data: <?php echo mysqli_error($link); ?>');
  </script>
  <?php
 }
}

 if(isset($_POST['btn-cancel']))
 {
	header("Location: inventory.php");
	exit(); 
 }
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta charset="UTF-8"/>
<title>C113193101 林家禾我的庫存</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>

<?php include_once "header.php"?>

<div id="main">
 <div id="content">
    <form method="post">
    <table class="w3-table-all w3-hoverable w3-card-4 stock-table">
	
		 <tr>
        <td><strong>目前正在編輯的股票：</strong><?php echo $fetched_row['stock_name']. " (" . $fetched_row['stock_code'] . ")"; ?></td>
        </tr>
	
		<tr>
		<td><input type="number" name="quantity" placeholder="股數" min="0.01" step="0.01" value="<?php echo $fetched_row['quantity']; ?>" required /></td>
		</tr>
		<tr>
		<td><input type="number" name="avg_cost" placeholder="平均成本" min="0" step="0.01" value="<?php echo $fetched_row['avg_cost']; ?>" required /></td>
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
