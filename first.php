    <div class="banner">
        <div class="container">
            <div class="row"> 
                <div class="col-xs-12"> 
                    <div class="banner_desc"> 
                        <br/><br/><br/><br/><br/><br/>
                        <h1>
                            Порадуй своего любимца подарком!
                        </h1>
                        <h2>
                            Распродажа уже началась!
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="content-top">
        <br/><br/><br/><br/>
        <h3 class="m_1">
            Самые популярные товары
        </h3>
        <div class="container">
            <div class="col-md-12">
                <div class="section group">
                    <?php
                            $select = 'SELECT * FROM  `tovar` WHERE `photo`>0 ORDER BY `mark` DESC LIMIT 3'; 
                            $query = mysqli_query($db_server,$select); 
                            $row = mysqli_fetch_assoc($query);
                            do{
                                $dir='images/'.$row['id'].'/';
                                $images = scandir($dir);
                                echo ' 
                                    <div class="col_1_of_3 span_1_of_3 simpleCart_shelfItem">
                                        <div class="shop-holder1"> 
                                            <div class="product-img">
                                                <a href="index.php?page=tovar&id='.$row['id'].'">
                                                    <img width="100%" height="265" src="'.$dir.$images['2'].'" class="img-responsive" alt="item4">
                                                </a>
                                            </div>
                                        </div>
                                        <div class="shop-content" style="height: 80px;">
                                            <div>'.$row['category'].'</div>
                                            <h3><a href="single.html">'.$row['name'].'</a></h3>
                                            <span class="amount item_price">'.$row['price'].' руб</span>
                                        </div>
                                    </div>
                                ';
                            } while($row = mysqli_fetch_assoc($query));
                    ?>
                </div>
            </div>
        </div>
    </div>