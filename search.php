<?php
    if (isset($_POST['submit'])){
        $select = "SELECT * FROM  `tovar` WHERE  `name` LIKE  '%".$_POST['sumbit']."%'";
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
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
        
    }
    else echo '<div class="alert alert-warning"><strong>Ничего не найдено!</strong></div>';

?>