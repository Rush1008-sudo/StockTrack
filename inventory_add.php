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
	
	// 在畫面載入前，撈出所有股票供之後下拉式選單使用
	$sql_stocks = "SELECT stock_id, stock_code, stock_name FROM stock_list";
	$result_stocks = mysqli_query($link, $sql_stocks);
	
	if(isset($_POST['btn-save']))
	{
		$stock_id = intval($_POST['stock_id']); // 外鍵FK
		$quantity = floatval($_POST['quantity']); // 持有股數
		$avg_cost = floatval($_POST['avg_cost']); // 平均買入成本
		
		//寫入資料表，市值與未實現損益交給inventory.php中進行計算
		$sql_query = "INSERT INTO stock_inventory(stock_id, quantity, avg_cost) VALUES($stock_id, $quantity, $avg_cost)";
                      
		if(mysqli_query($link, $sql_query)) {
			// 新增成功後跳出提示，並自動跳轉回庫存頁面
			echo "<script>alert('庫存新增成功，市值與損益已自動計算完畢！'); window.location.href='inventory.php';</script>";
		} else {
			echo "<script>alert('新增失敗：" . mysqli_error($link) . "');</script>";
		}
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
			<td align="center"><a href="inventory.php">back to asset page</a></td>
			</tr>
			<tr>
			<td>
				<!--建立下拉式選單從剛剛stock_list中撈出現有的股票供用戶選擇-->
				<select name="stock_id" required style="width: 100%; padding: 5px;">
					<option value="">-- 請選擇股票 --</option>
					<?php while($row = mysqli_fetch_assoc($result_stocks)): ?>
						<option value="<?php echo $row['stock_id']; ?>">
							<?php echo $row['stock_code'] . " - " . $row['stock_name']; ?>
						</option>
					<?php endwhile; ?> 
				</select>
			</td>
			</tr>
			
			<tr>
			<td><input type="number" name="quantity" placeholder="股數" min="0.01" step="0.01" required /></td>
			</tr>
			<tr>
			<td><input type="number" name="avg_cost" placeholder="平均成本" min="0" step="0.01" required /></td>
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
