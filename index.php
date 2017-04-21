<?php
    session_start();
    include ('connect.php');
    ini_set('session.gc_maxlifetime', 9800);
    if (!isset($_SESSION['cart'])) $_SESSION['cart']=0;

    if ($_POST['newidincart']){
        $_SESSION['cart'] += 1;
        $t=$_SESSION['cart'];
        $_SESSION['lastsum'][$t]=$_POST['lastsum']*$_POST['kol'];
    }
    if (isset($_GET['deltovar'])){
        for ($i=$_GET['deltovar']; $i<$_SESSION['cart']; $i++){
            $_SESSION['zakaz'][$i]=$_SESSION['zakaz'][$i+1] ;
            $_SESSION['lastsum'][$i]=$_SESSION['lastsum'][$i+1] ; 
        }
        $_SESSION['cart']=$_SESSION['cart']-1;
    }
    if (isset($_GET['page'])) $page=$_GET['page'];
    if (!isset($page)) $page='first';
    $_SESSION['sum']=0;
    for ($i=1; $i <= $_SESSION['cart']; $i++){
        $_SESSION['sum']+=$_SESSION['lastsum'][$i];
    }
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="
                                    <?php
                                        $select = 'SELECT * FROM `sitinfo` WHERE  id=2';
                                        $query = mysqli_query($db_server,$select);
                                        $row = mysqli_fetch_assoc($query);
                                        echo $row['znach'];
                                    ?>
                                   " /> 
    <meta charset="utf-8" />
    <?php
    if ($page=='fisrt') { $select = 'SELECT * FROM `sitinfo` WHERE  id=1';
                            $query = mysqli_query($db_server,$select);
                            $row = mysqli_fetch_assoc($query);
                            echo '<title>'.$row['znach'].'</title> ';
                        }
    if ($page=='category') {$na= $_GET['name']; $select = "SELECT * FROM `category` WHERE  `tname`='$na'";
                            $query = mysqli_query($db_server,$select);
                            $row = mysqli_fetch_assoc($query);
                            echo '<title>'.$row['name'].'</title> ';
                           }
    if ($page=='tovar')
    
    ?>
    <!-- Bootstrap Styles-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" /> 
    <!-- FontAwesome Styles--> 
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- Google Fonts-->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <!-- own style -->
    <script src="jquery/jquery-1.11.2.min.js"></script>
    <link href='css/style.css' rel='stylesheet' type='text/css' />
    <link href='css/megamenu.css' rel='stylesheet' type='text/css' />
    
</head>
<body>
    <div class="wrap-box"></div>
    <div class="container header_bottom">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-2 logo"> 
                    <h1>
                        <a href="index.php">
                            <span>
                                <?php
                                    $select = 'SELECT * FROM `sitinfo` WHERE  id=1';
                                    $query = mysqli_query($db_server,$select);
                                    $row = mysqli_fetch_assoc($query);
                                    echo $row['znach'];
                                ?>
                            </span>
                        </a>
                    </h1>
                </div>
                <div class="col-xs-4">
                </div>
                <div class="col-xs-4">
                    <div class="search">	  
                        <form method="POST" action="seach.php">
                            <form method="post" action="index.php?page=search"><input type="text" name="s" class="textbox" value="Search" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Search';}">
                            <input type="submit" value="Subscribe" id="submit" name="submit"></form>
                            <div id="response"> </div>
                        </form>
                    </div>
                </div>
                <div class="col-xs-2">
                    <div class="box_1-cart">
                         <div class="box_11"><a href="index.php?page=cart">
                          <h4><p>Корзина<span class="simpleCart_total"></span> (<span id="simpleCart_quantity" class="simpleCart_quantity"></span>
                              <?php
                                echo $_SESSION['cart'];
                              ?>
                              )</p><img src="images/bag.png" alt=""><div class="clearfix"> </div></h4>
                          </a></div>
	               </div>
                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-xs-2"></div>
                <div class="col-xs-8">
                    <ul class="megamenu skyblue">
                        <?php
                            $select = 'SELECT * FROM `category` WHERE  active=1';
                            $query = mysqli_query($db_server,$select);
                            $row = mysqli_fetch_assoc($query);
                            do{
                                echo ' 
                                    <li class="active grid">
                                        <a class="color5" href="index.php?page=category&name='.$row['tname'].'">
                                            '.$row['name'].'
                                        </a>
                                    </li>';
                            } while($row = mysqli_fetch_assoc($query));
                            echo '
                            <li class="active grid">
                                <a class="color5" href="index.php?page=kontact">Контакты</a>
                            </li>';
                        ?>
                    </ul>
                </div>
                <div class="col-xs-2"></div>
            </div>
            <hr/>
        </div>
        <div class="row">
            <div class="col-xs-6"></div>
            <div class="col-xs-6"> 
                
            </div>
        </div>
    </div> 
<?php
    if ($page=='first') include('first.php');
    if ($page=='category') include('category.php');
    if ($page=='tovar') include('tovar.php');
    if ($page=='cart') include('cart.php');
    if ($page=='kontact') include('kontact.php');
    if ($page=='form') include('form.php');
    if ($page=='search') include('search.php');
?>
    <br/><br/><br/><br/> 
    <hr/>
    <div class="copy">
        <p>Copyright © 2016 Elkhova Ekaterina</p>
    </div>
</body>
</html>		