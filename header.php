
<link rel="stylesheet" href="w3.css"> 

<header id="top" class="w3-panel w3-center w3-opacity">
  <h1 class="w3-xlarge">Stock Asset Management System</h1> 
  <h1 class="w3-xxlarge">CRUD by 林家禾</h1>
  
  <div class="w3-padding-16">
    <div class="w3-bar w3-white w3-card w3-round">
        
        <a href="main.php" class="w3-bar-item w3-button w3-hover-indigo">Home</a>
        <a href="inventory.php" class="w3-bar-item w3-button w3-hover-indigo">My Asset</a>
		
		<!--其他有嵌入header.php的已經有session_start();所以不用額外寫-->
		<!---判斷是否登入，已登入顯示Logout button--->
        <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
            <a href="logout.php" class="w3-bar-item w3-button w3-red">Logout</a>  
			
		<!---判斷是否登入，未登入顯示LogIn button--->	
        <?php else: ?>
            <a href="index.php" class="w3-bar-item w3-button w3-green">Log In</a> 
			
		<!--一定要告知if結束了，不然會壞掉-->	
        <?php endif; ?>
		
    </div>
  </div>
  <!---未登入顯示訪客提示--->		
  <?php if(!(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)): ?>
      <div class="w3-panel w3-amber w3-center w3-round w3-card-2" style="max-width: 80%; margin: 15px auto; padding: 4px 16px;">
          <p>💡 <strong>系統提示：</strong>您目前處於「訪客模式」，僅供瀏覽，如需進行操作請先登入。</p>
      </div>
  	  
  <?php endif; ?>

</header>



