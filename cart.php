<div class="container">
<div class="col-xs-9 cart-items">
			 <h1>Корзина</h1>
    <div class="row">
    <?php 
    if ($_SESSION['cart'] == 0) echo '<div class="alert alert-warning"><strong>Ваша корзина пуста</strong></div>';
    else {
            $id=$_GET['id'];
            $select = "SELECT * FROM  `tovar` WHERE  `id` =  '$id'";
            $query = mysqli_query($db_server,$select);
            $row = mysqli_fetch_assoc($query);
            $s = "SELECT * FROM  `costs` WHERE  `idoftovar` =  '$id' ORDER BY `type`";
            $q = mysqli_query($db_server,$s);
            $w = mysqli_fetch_assoc($q);
            $m='';
            $s='';
            $p='<p>Количество:'.$_POST['kol'].'</p><p>Cумма за 1 шт:'.$_POST['lastsum'].'</p><p>Итого: '.$_SESSION['lastsum'][$_SESSION['cart']].'</p>';
            do {
                if ($m != $w['type']) $s.='<li><p>'.$w['type'].': '.$_POST[$w['type']].'</p></li>';
                $m=$w['type'];
            } while ($w = mysqli_fetch_assoc($q));
            $dir='images/'.$row['id'].'/';
            $images = scandir($dir);
            if ($row['a'] != 0) $s.= '<li><p>Длина: '.$row['a'].' см</p></li>';
            if ($row['b'] != 0) $s.= '<li><p>Ширина: '.$row['b'].' см</p></li>';
            if ($row['c'] != 0) $s.= '<li><p>Высота: '.$row['c'].' см</p></li>';
            if ($row['d'] != 0) $s.= '<li><p>Диаметр: '.$row['d'].' см</p></li>';
            if ($row['v'] != 0) $s.= '<li><p>Объем: '.$row['v'].' мл</p></li>';
            if ($row['m'] != 0) $s.= '<li><p>Масса: '.$row['m'].' кг</p></li>';

            $l='
                <div class="cart-header col-xs-9">
                     <a href="index.php?page=cart&deltovar='.$row['id'].'"><div class="close1"> </div></a>
                         <div class="cart-sec simpleCart_shelfItem">
                                <div class="cart-item cyc">
                                     <img src="'.$dir.$images[2].'" class="img-responsive" alt="">
                                </div>
                               <div class="cart-item-info">
                                <h3><a href="index.php?page=tovar&id='.$row['id'].'">'.$row['name'].'</a></h3>
                                <ul class="qty">
                                    '.$s.'
                                </ul>
                                '.$p.'
                               </div>
                               <div class="clearfix"></div>

                          </div>
                 </div>
            ';
            $_SESSION['zakaz'][$t]=$l;
            for ($i=1; $i<=$_SESSION['cart']; $i++) echo $_SESSION['zakaz'][$i];
            
        }        
    ?>
    </div>
</div>
    <div class="col-md-3 cart-total">		 	
        <ul class="total_price">
            <li class="last_price"> <h4>Всего:</h4></li>	
            <li class="last_price"><span><?php echo $_SESSION['sum']; ?></span>руб 00 коп</li>
            <div class="clearfix"> </div>
        </ul>	 
        <div class="clearfix"></div>
        <a class="continue" href="index.php?page=form">Продолжить заказ</a>
    </div>
</div>