<!--這段主要用來阻擋未登入就在main.php進行刪除-->
<?php
session_start();

include_once 'dbconfig.php';
//是否有刪除請求
if(isset($_GET['delete_id'])) 
{
 if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)) 
 {
        header("Refresh: 3; url=index.php");
		die("<h2 style='color:red; text-align:center; margin-top:100px;'> 
         ⚠️ 請不要偷溜進來或執行操作！請乖乖登入... 系統將在 3 秒後自動跳轉。
         </h2>"); /*因為die會作廢下面的程式碼自然讀不到style.css所以必須寫上去*/
 }
 //有刪除請求時，又確認登入則執行下面程式
 $sql_query="DELETE FROM stock_list WHERE stock_id=".$_GET['delete_id'];
 mysqli_query($link, $sql_query);
 header("Location: $_SERVER[PHP_SELF]");
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<meta charset="UTF-8"/>
<title>StockTrack - Portfolio Management System</title>
<link rel="stylesheet" href="style.css" />
<script>
	function edt_id(id)
	{
	 if(confirm('Sure to edit ?'))
	 {
	  window.location.href='edit_data.php?edit_id='+id;
	 }
	}
	function delete_id(id)
	{
	 if(confirm('Sure to Delete ?'))
	 {
	  window.location.href='main.php?delete_id='+id;
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
	<th colspan="5">股票資訊</th>
    <th colspan="2"><a href="add_data.php">add data here.</a></th>
    </tr>
	<tr>
    <th>股票代碼</th>
    <th>股票名字</th>
    <th>目前價格</th>
	<th>行業別</th>
	<th>更新時間</th>
    <th colspan="2">Operations</th>
    </tr>
    <?php
 $sql_query="SELECT * FROM stock_list";
 $result_set = mysqli_query($link, $sql_query);
 while ($row = mysqli_fetch_row($result_set))
 {
  ?>
        <tr>
        <td><?php echo $row[1]; ?></td>
        <td><?php echo $row[2]; ?></td>
        <td><?php echo $row[3]; ?></td>
		<td><?php echo $row[4]; ?></td>
		<td><?php echo $row[5]; ?></td>
		<td align="center"><a href="javascript:edt_id('<?php echo $row[0]; ?>')"><img src="b_edit.png" align="EDIT" /></a></td>
        <td align="center"><a href="javascript:delete_id('<?php echo $row[0]; ?>')"><img src="b_drop.png" align="DELETE" /></a></td>
        </tr>
        <?php
 }
 ?>
    </table>
    </div>
</div>

<?php include_once "footer.php"?>

</body>
</html>