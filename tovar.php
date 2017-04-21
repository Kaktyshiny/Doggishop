<div class="container">
    <ul class="breadcrumbs">
        <li><a href="/">Главная</a></li>
        <li>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </li>
        <li>
                <?php
                    $sum=0;
                    if (!isset($_GET['col'])) $col = 1 ; else $col = $_GET['col'];
                    $id=$_GET['id'];
                    $select = "SELECT * FROM  `tovar` WHERE  `id` =  '$id'";
                    $query = mysqli_query($db_server,$select);
                    $row = mysqli_fetch_assoc($query);
                    $h=$row['category;'];
                    $sel = "SELECT * FROM  `category` WHERE  `name` =  '$h'";
                    $qu = mysqli_query($db_server,$sel);
                    $r = mysqli_fetch_assoc($qu);
                    echo '<a href="index.php?page=category&name='.$r['tname'].'">'.$row['category'].'</a>';
                ?>
        </li>
        <li>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </li>
        <li>
            <?php echo $row['name']; ?>
        </li>
    </ul>
    
    <script>
        function plus(n) {
         var cena=document.getElementById("cena_"+n);
         var col=document.getElementById("col_"+n);
         var cenap=document.getElementById("cenap_"+n);
         var itog=document.getElementById("itog");

         col.innerHTML=1+Number(col.innerHTML);
         cenap.innerHTML=Number(cenap.innerHTML)+Number(cena.innerHTML);
         itog.innerHTML=Number(itog.innerHTML)+Number(cena.innerHTML);
        }
        function minus(n) {
         var cena=document.getElementById("cena_"+n);
         var col=document.getElementById("col_"+n);
         var cenap=document.getElementById("cenap_"+n);
         var itog=document.getElementById("itog");
        

        if(col.innerHTML!="0") {
        col.innerHTML=Number(col.innerHTML)-1;
        cenap.innerHTML=Number(cenap.innerHTML)-Number(cena.innerHTML);
        itog.innerHTML=Number(itog.innerHTML)-Number(cena.innerHTML);
        

         }
        }

        </script>
    <div class="single_grid">
        <div class="row">
        <div class="col-xs-4">
                <?php
                if ($row['photo']>0){
                    $dir='images/'.$row['id'].'/';
                    $images = scandir($dir);
                    for ($i=2; $i<count($images);$i++){
                        if (file_exists($dir.$images[$i])){
                            echo '
                                        <img class="etalage_thumb_image" src="'.$dir.$images[$i].'" style="display: inline; width: 300px; height: 400px; opacity: 1;">
                            ';
                        }
                    }
                }
                ?>
            <div class="clearfix"></div>
        </div> 
        <div class="col-xs-8">
            <form <?php if (!isset($_POST['chet'])) echo 'action="index.php?page=tovar&id='.$_GET['id'].'"'; else echo 'action="index.php?page=cart&id='.$_GET['id'].'"';  ?> method="POST">  
            <h1><?php echo $row['name']; ?></h1>
            <p><?php echo $row['big']; ?></p>
            <p><?php if ($row['a'] != 0) echo 'Длина: '.$row['a'].' см'; ?></p>
            <p><?php if ($row['b'] != 0) echo 'Ширина: '.$row['b'].' см'; ?></p>
            <p><?php if ($row['c'] != 0) echo 'Высота: '.$row['c'].' см'; ?></p>
            <p><?php if ($row['d'] != 0) echo 'Диаметр: '.$row['d'].' см'; ?></p>
            <p><?php if ($row['v'] != 0) echo 'Объем: '.$row['v'].' мл'; ?></p>
            <p><?php if ($row['m'] != 0) echo 'Масса: '.$row['m'].' кг'; ?></p>
            <div class="dropdown_top">
                <div class="dropdown_left">
                        <?php 
                        $n=$row['id'];
                        $s = "SELECT * FROM  `costs` WHERE  `idoftovar` = $n ORDER BY  `type` ";
                        $q = mysqli_query($db_server,$s);
                        $w = mysqli_fetch_assoc($q);
                        //echo $w['name'];
                        if ($w['id']>0){
                            echo '<div class="col-xs-6"><div class="form-group">';
                            echo '<label>'.$w['type'].'</label><select name="'.$w['type'].'" class="form-control">';
                            $k=$w['type'];
                            do{
                                if (($w['type'] != $k)) {
                                    $k=$w['type'];
                                    echo '</select><label>'.$w['type'].'</label><select name="'.$w['type'].'" class="form-control">';
                                    echo '<option';
                                    if ($_POST[$w['type']]==$w['name']) {echo ' selected="selected" '; $sum=$sum+$w['plus'];}
                                    echo '>'.$w['name'].'</option>';
                                    
                                }
                                else {
                                    echo '<option';
                                    if ($_POST[$w['type']]==$w['name']) {echo ' selected="selected" '; $sum=$sum+$w['plus'];}
                                    echo '>'.$w['name'].'</option>'; 
                                }
                            }  while($w = mysqli_fetch_assoc($q));
                            echo '</select></div></div>';
                        }
                        ?>
                
                </div>
                
                <div class="col-xs-3">
                <label>Выберите количество: </label><br>
                <input name="kol"  class="form-control" value="<?php if (($_POST['kol']!=1)and ($_POST['kol']!='')) echo $_POST['kol']; else echo '1'; ?>"/>
                <input name="lastsum" type="hidden" value="<?php echo $row['price']+$sum; ?>">
                </div>
                <div class="clearfix"></div>
            </div>
            <?php if (!isset($_POST['chet'])) echo'<input name="chet" type="submit" class="btn btn-success" value="Посчитать цену"/>'; ?>
            <div class="simpleCart_shelfItem">
            <?php
                if (isset($_POST['chet'])){
                    $col=$_POST['kol'];
                echo '<div class="price_single">
                    <div class="head"><h4><span class="amount item_price" id="cena_1">  ';
                                                                                        echo $row['price']+$sum; 
                                                                                                                 echo'   </span> руб за 1 штуку</h4></div>
                    <div class="head"><h4><span class="amount item_price" id="cenap_1">'; echo $col*($row['price']+$sum); echo '</span> руб всего</h4></div>
                    <div class="clearfix"></div>
                </div>';
                }
            ?>
                <!--<div class="single_but"><a href="" class="item_add btn_3" value=""></a></div>-->
                <br>
                <br>
                
                <?php  if (isset($_POST['chet'])) echo ' <div class="size_2-right"><input name="newidincart"  type="submit" class="btn btn-warning" value="Добавить в корзину"/></div>'; ?>
                </form>
            </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <script>
    </script>
    </div>
   
</div>