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

if(isset($_GET['delete_id']))
{
 $sql_query="DELETE FROM stock_inventory WHERE inventory_id =".$_GET['delete_id'];
 mysqli_query($link, $sql_query);
 header("Location: $_SERVER[PHP_SELF]");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta charset="UTF-8"/> 
<title>StockTrack - Portfolio Management System 我的庫存</title>
<link rel="stylesheet" href="style.css" />
<script>
	function edt_id(id)
	{
	 if(confirm('Sure to edit ?'))
	 {
	  window.location.href='inventory_edit.php?edit_id='+id;
	 }
	}
	function delete_id(id)
	{
	 if(confirm('Sure to Delete ?'))
	 {
	  window.location.href='inventory.php?delete_id='+id;
	 }
	}
</script>
</head>
<body>

<?php include_once "header.php"?>

<div id="main">
 <div id="content">
    <table class="w3-table-all w3-hoverable w3-card-4 stock-table">
    <tr>
	<th colspan="6">庫存資訊</th>
    <th colspan="2"><a href="inventory_add.php">add data here.</a></th>
    </tr>
	<tr>
    <th>股票代碼</th>
    <th>股票名字</th>
    <th>股數</th>
	<th>平均成本</th>
	<th>目前市值</th>
	<th>未實現損益</th>
    <th colspan="2">Operations</th>
    </tr>
     <?php
	//設定總資產跟總未實現損益初始值 
	$total_ave_cost = 0;
	$total_market_value = 0;
    $total_unrealized_profit = 0;
    
    // 使用INNER JOIN關聯兩張資料表的stock_id，並select所需要的欄位資料
     $sql_query = "SELECT 
                    i.inventory_id, 
                    l.stock_code, 
                    l.stock_name, 
                    i.quantity, 
                    i.avg_cost, 
                    l.current_price 
                  FROM stock_inventory i
                  INNER JOIN stock_list l ON i.stock_id = l.stock_id";
 
    $result_set = mysqli_query($link, $sql_query);
 while ($row = mysqli_fetch_row($result_set))
 {	
		//floatval()為抓取為小數點
		$quantity = floatval($row[3]);  
        $avg_cost = floatval($row[4]);
        $current_price = floatval($row[5]); // stock_list的最新現價

        //判定美股與台股的匯率
        $stock_code = trim($row[1]);
        $exchange_rate = 1.0; //預設為新台幣(匯率不變)
		//如果股票代碼全英文判斷為美股將匯率改為美元
        if (ctype_alpha($stock_code)) {
            $exchange_rate = 31.58; // 2026年6月6日美金兌台幣匯率
        }
		
        $live_ave_cost = $avg_cost * $quantity * $exchange_rate; //即時台幣成本
        $live_market_value = $quantity * $current_price * $exchange_rate;  // 即時台幣市值
        $live_unrealized_profit = $live_market_value - ($quantity * $avg_cost * $exchange_rate); // 即時台幣未實現損益
		//個別的未實現損益百分比%
		$live_profit_percent = 0.00;
        if ($live_ave_cost > 0) {
            $live_profit_percent = ($live_unrealized_profit / $live_ave_cost) * 100;
        }
		
		// 未實現損益綠漲紅跌判斷
        $color_style = ""; 
        if ($live_unrealized_profit > 0) {
            $color_style = "color: #00cc66; font-weight: bold;"; 
        } elseif ($live_unrealized_profit < 0) {
            $color_style = "color: #ff3333; font-weight: bold;"; 
        } 
		
        
        // 累加總資產
		$total_ave_cost += $live_ave_cost;
        $total_market_value += $live_market_value;
		
  ?>
        <tr>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <!-- 如果股數有小數點（碎股），顯示小數點後兩位 -->
        <td><?php echo number_format($quantity, 2); ?></td>
		<td><?php echo number_format($avg_cost, 2); ?></td>
        
        <!-- 除了平均成本，市值與未實現損益都用TWD計價  -->
		<td><?php echo number_format($live_market_value, 2); ?> TWD</td>
		<td style="<?php echo $color_style; ?>">
			<?php 
			// 金額前端加上+判定，並先印出金額與 TWD
			if ($live_unrealized_profit > 0) { echo "+"; } 
			echo number_format($live_unrealized_profit, 2) . " TWD "; 
			
			// 百分比的+-判斷
			if ($live_profit_percent > 0) {
				
				echo "(+" . number_format($live_profit_percent, 2) . "%)";
			} else {
				
				echo "(" . number_format($live_profit_percent, 2) . "%)";
			} 
			?>
		</td> 
		
		<td align="center"><a href="javascript:edt_id('<?php echo $row[0]; ?>')"><img src="b_edit.png" alt="EDIT" /></a></td>
        <td align="center"><a href="javascript:delete_id('<?php echo $row[0]; ?>')"><img src="b_drop.png" alt="DELETE" /></a></td>
        </tr>
  <?php
 } 
 
 $total_unrealized_profit = $total_market_value - $total_ave_cost; //總未實現損益計算
 $total_profit_percent = 0.00;  
 //總未實現損益百分比計算
 if ($total_ave_cost > 0) {
     $total_profit_percent = ($total_unrealized_profit / $total_ave_cost) * 100;
 }

 //總損益綠漲紅跌判斷
 $total_profit_style = "";
 if ($total_unrealized_profit > 0) {
     $total_profit_style = "color: #00cc66; font-weight: bold;";
 } elseif ($total_unrealized_profit < 0) {
     $total_profit_style = "color: #ff3333; font-weight: bold;";
 }
 ?>
    
    <!-- 總計列 -->
	<tr style="background-color: #f5f5f5; font-weight: bold;">
        <td colspan="3" align="left">目前總資產(換算台幣 TWD)：</td>
		<td><span id="total_style">總成本(TWD)</span><?php echo number_format($total_ave_cost, 2); ?></td>
        <td><?php echo number_format($total_market_value, 2); ?></td>
        <td style="<?php echo $total_profit_style; ?>">
			<?php 
			if ($total_unrealized_profit > 0) { echo "+"; }
			echo number_format($total_unrealized_profit, 2) . " TWD ";
			if ($total_profit_percent > 0) {
				echo "(+" . number_format($total_profit_percent, 2) . "%)";
			} else {
				echo "(" . number_format($total_profit_percent, 2) . "%)";
			}
			?>
		</td>
        <td colspan="2"></td>
    </tr>
	
    </table>
    </div>
</div>

<?php include_once "footer.php"?>

</body>
</html>
