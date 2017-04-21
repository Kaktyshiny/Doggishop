<div class="container">
    <ul class="breadcrumbs">
        <li><a href="/">Главная</a></li>
        <li>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </li>
        <li>
                <?php
                    $cat=$_GET['name'];
                    $select = "SELECT * FROM  `category` WHERE  `tname` =  '$cat'";
                    $query = mysqli_query($db_server,$select);
                    $row = mysqli_fetch_assoc($query);
                    echo $row['name'];
                    $s=$row['name'];
                ?>
        </li>
    </ul>
    <div class="row">
		
                    <?php
                    $select = "SELECT * FROM  `podcategory` WHERE  `category` =  '$s'";
                    $query = mysqli_query($db_server,$select);
                    $row = mysqli_fetch_assoc($query);
                    if ($row['id']>0){
                        $l=" ";
                        if (isset($_POST['filter'])) {
                            echo $_POST['checkbox'];
                        }
                        $query = mysqli_query($db_server,$select);
                        $row = mysqli_fetch_assoc($query);
                        echo '
                        <div class="col-md-3">
                            <div class="w_sidebar">
                                <br/>
                                <h3>Фильтры</h3>
                                <section class="sky-form">
                                    <h4>Подкатегории</h4>
                                    <div class="row1 scroll-pane">
                                        <div class="col col-4">
                                            <form action="index.php?page=category&name='.$_GET['name'].'" method="POST">
                        ';
                        do {
                            if (isset($_POST['filter'])){
                                if ($_POST[$row['id']]){
                                    $h=$row['name'];
                                
                                    if ($l != " ") $l = $l." or `podcat`='$h'";
                                    if ($l == " ") $l="`podcat`='$h'";
                                    echo '<label class="checkbox"><input type="checkbox" checked name="'.$row['id'].'"><i></i>'.$row['name'].'</label>';
                                }
                                else echo '<label class="checkbox"><input type="checkbox" name="'.$row['id'].'"><i></i>'.$row['name'].'</label>';
                            }
                            else echo '<label class="checkbox"><input type="checkbox" name="'.$row['id'].'"><i></i>'.$row['name'].'</label>';
                        } while($row = mysqli_fetch_assoc($query));
                        echo ' <input class="btn btn-warning" name="filter" type="submit" value="Показать"> 
                                            </form>
                                        </div>
                                    </div> 
                                </section> 
                            </div>
                        </div>
                        ';
                    }
                    ?>
        <div class="col-md-9">
                <?php
                if (isset($_POST['filter'])) $select = "SELECT * FROM  `tovar` WHERE `photo`>0 and `category`='$s' and ($l)"; 
                else $select = "SELECT * FROM  `tovar` WHERE `photo`>0 and `category`='$s'"; 
                //echo $select;
                $query = mysqli_query($db_server,$select); 
                $row = mysqli_fetch_assoc($query);
                if ($row['id']>0) {
                $i=0;
                do{
                    $dir='images/'.$row['id'].'/';
                    $images = scandir($dir);
                    if ($i % 3 == 0) echo '<div class="section group"><div class="row">';
                    echo '
                    <div class="col_1_of_3 span_1_of_3 simpleCart_shelfItem">
                        <div class="shop-holder1">
                            <div class="product-img">
                                <a href="index.php?page=tovar&id='.$row['id'].'">
                                    <img width="100%" height="265" src="'.$dir.$images['2'].'" class="img-responsive" alt="">
                                </a>
                            </div>
                        </div>
                    <div class="shop-content">
                    <h4><a href="index.php?page=tovar&id='.$row['id'].'">'.$row['name'].'</a></h4>
                    <span class="amount item_price">'.$row['price'].' руб</span>
                    </div>
                    </div>
                    ';
                    $i++;
                    if ($i % 3 == 0) echo '</div></div>';
                } while($row = mysqli_fetch_assoc($query));
                } else echo'<div class="alert alert-warning"><strong>Товаров не найдено!</strong></div>';
                ?>
        </div>
    </div>
</div>