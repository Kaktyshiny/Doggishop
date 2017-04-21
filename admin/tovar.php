<?php 
    if (!isset($_GET['action'])) $action='view';
    else $action=$_GET['action'];
    if (!isset($_GET['type'])) $type='id';
    else $type=$_GET['type'];
    if (!isset($_GET['numb'])) $numb=0;
    else $numb=$_GET['numb'];

    if (isset($_POST['costsnewison'])){
        $goodcreatecost=true;
        if ($goodcreatecost) {
            $action='costthis';
            $idoftovar=$_GET['id'];
            $name=$_POST['name'];
            $type=$_POST['type'];
            $plus=$_POST['plus'];
            $query="INSERT INTO `costs` (idoftovar, name, type, plus) VALUES('$idoftovar','$name', '$type', '$plus');"; 
            mysqli_query($db_server,$query); 
        }
    }
    if ($action == 'delc'){
        $name=$_GET['name']; 
        $query="DELETE FROM  `costs`  WHERE  `id` =  '$name'";
		mysqli_query($db_server, $query);
        $action='costthis';
        $delcost=true;
    }
    if ($action == 'delallcost'){
        $i=$_GET['id'];
        $query="DELETE FROM  `costs`  WHERE  `idoftovar` =  '$i'";
		mysqli_query($db_server, $query);
        $action='costthis';
        $gooddelcostall=true;
    }
    if ($action=='delthisphoto'){
        unlink('../images/'.$_GET['id'].'/'.$_GET['namephoto'].'');
        $gooddelphoto=true;
        $action='photothis';
        $select = 'SELECT * FROM `tovar` WHERE `id`='.$_GET['id'];
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        $photo = $row['photo'] - 1;
        $edit = 'UPDATE `tovar` SET `photo`='.$photo.' WHERE `id`= '.$_GET['id'].';';
        $query = mysqli_query($db_server, $edit);
        
    }
    if ($action=='delallphoto'){
        if($handle = opendir('../images/'.$_GET['id'].'/'))
            {
                    while(false !== ($file = readdir($handle)))
                            if($file != "." && $file != "..") unlink('../images/'.$_GET['id'].'/'.$file);
                    closedir($handle);
            }
        $edit = 'UPDATE `tovar` SET `photo`=0 WHERE `id`= '.$_GET['id'].';';
        $query = mysqli_query($db_server, $edit);
        $action='photothis';
        $gooddelallphoto=true;
        
    }
    if (isset($_POST['imagesnewison'])){
                $blacklist = array(".php", ".phtml", ".php3", ".php4");
        foreach ($blacklist as $item) {
            if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
                $goodcreate = false;
                $mes= "Неверный формат";
                    exit;
            }
        }
        if (file_exists("../images/".$_GET['id']."/")) echo ''; else mkdir("../images/".$_GET['id']."/");
        $id=$_POST['id'];
        $uploaddir = '../images/'.$_GET['id'].'/';
        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            $goodcreate = true;
            $select = 'SELECT * FROM `tovar` WHERE `id`='.$_GET['id'];
            $query = mysqli_query($db_server,$select);
            $row = mysqli_fetch_assoc($query);
            $photo = $row['photo'] + 1;
            $edit = 'UPDATE `tovar` SET `photo`='.$photo.' WHERE `id`= '.$_GET['id'].';';
            $query = mysqli_query($db_server, $edit);
       } else {
            $goodcreate = false;
            $mes= "Загрузка не удалась";
        }
    }
    if (isset($_POST['tovarnewison'])){
        $goodcreate=true;
        if ($goodcreate) {
            $action='newphoto';
            $name=$_POST['name'];
            if ($_POST['big']!='') $big=$_POST['big']; else $big='0';
            if ($_POST['a']!='') $a=$_POST['a']; else $a='0';
            if ($_POST['b']!='') $b=$_POST['b']; else $b='0';
            if ($_POST['c']!='') $c=$_POST['b']; else $c='0';
            if ($_POST['d']!='') $d=$_POST['b']; else $d='0';
            if ($_POST['v']!='') $v=$_POST['b']; else $v='0';
            if ($_POST['m']!='') $m=$_POST['b']; else $m='0';
            if ($_POST['price']!='') $price=$_POST['price']; else $price='0';
            $category=$_POST['category'];
            $podcategory=$_POST['podcategory'];
            $query="INSERT INTO `tovar` (name, big, a, b, c, d, v, m, category, podcat, photo, price) VALUES('$name', '$big', '$a', '$b', '$c', '$d', '$v', '$m', '$category', '$podcategory', '0', '$price');"; 
            mysqli_query($db_server,$query);
        }
    }
    if (isset($_POST['editison'])){
        $name=$_POST['name'];
        $big=$_POST['big'];
        $a=$_POST['a'];
        $b=$_POST['b'];
        $c=$_POST['c'];
        $d=$_POST['d'];
        $v=$_POST['a'];
        $m=$_POST['b'];
        $category=$_POST['category'];
        $podcategory=$_POST['podcategory'];
        $id=$_GET['id'];
        $edit = "UPDATE `tovar` SET `name`='$name', `big`='$big', `a`='$a', `b`='$b', `c`='$c', `d`='$d', `v`='$v', `m`='$m', `category`='$category', `podcat`='$podcategory', WHERE `id`= $id";
        $query = mysqli_query($db_server, $edit);
        $goodedit=true;
    }

    if ($action=='del'){
        $i=$_GET['id'];
        $query="DELETE FROM  `tovar`  WHERE  `id` =  '$i'";
		mysqli_query($db_server, $query);
        $action='view';
        $gooddel=true;
    }
    if ($action=='delall'){
        $query="Truncate Table `tovar`";
		mysqli_query($db_server, $query);
        $action='view';
    }
    if ($action=='view'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Список товаров
                    </h1>
                </div>
            </div>
        ';
        if ((isset($_POST['tovarnewison']))||(isset($_POST['editison']))){
            if ($goodcreate) echo'<div class="alert alert-success"><strong>Товар успешно добавлен!</strong></div>';
            if ($goodedit) echo'<div class="alert alert-success"><strong>Товар успешно изменен!</strong></div>';
        }
        if ($gooddel) echo'<div class="alert alert-success"><strong>Товар успешно удален!</strong></div>';
        echo'
            <div class="row">
                <div class="col-md-12">
        ';
            $select = 'SELECT * FROM `tovar`';
            $query = mysqli_query($db_server,$select);
            $row = mysqli_fetch_assoc($query);
            $TOTAL = mysqli_num_rows($query);
        
            if ($numb==0) $fnumb = 0; else $fnumb = $numb*5;
            if ($fnumb==0) $lastnumb = $numb + 5;
            else $lastnumb = $numb + 4;
            if ($lastnumb>=$TOTAL) $lastnumb = $TOTAL;
            $select = 'SELECT * FROM `tovar` ORDER BY '.$type.' LIMIT '.$fnumb.','.$lastnumb;
            $query = mysqli_query($db_server,$select);
            $row = mysqli_fetch_assoc($query);
            //echo $select;
            $PAGES = ceil($TOTAL/5);
            echo '';
        if ($row['id']>0){
            echo '
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <th>№</th>
				                        <th><a href="admin.php?page=tovar&type=name">Название</a></th>
                                        <th><a href="admin.php?page=tovar&type=price">Цена</a></th>
                                        <th><a href="admin.php?page=tovar&type=category">Категория</a></th>
                                        <th><a href="admin.php?page=tovar&type=podcat">Подкатегория</a></th>
                                    </tr>                        
            ';
            $i=$fnumb+1;
            do{
                echo '<tr><td>'.$i.'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>от '.$row['price'].'</td>';
                echo '<td>'.$row['category'].'</td>';
                echo '<td>'.$row['podcat'].'</td></tr>';
                $i++;
            } while($row = mysqli_fetch_assoc($query));
            echo '                  </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                            </div>
                            <div class="col-lg-6">
                                <ul class="pagination">';
            $k=$numb-1;
            if ($numb == 0) echo '<li class="disabled"><a>«</a></li>';
                    else echo '<li><a h href="?page=tovar&type='.$type.'&numb='.$k.'">«</a></li>';
            for ($i=0; $i<$PAGES; $i++) 
           {
                    if ($i != $numb)
						echo '<li class="paginate_button"><a href="?page=tovar&type='.$type.'&numb='.$i.'">'.($i+1).'</a></li>';
					else 
						echo '<li class="paginate_button active"><a>'.($i+1).'</a></li>';
           }
            $k=$numb+1;
            if ($numb == $PAGES-1) echo '<li class="disabled"><a>»</a></li>';
            else echo '<li><a href="?page=tovar&type='.$type.'&numb='.$k.'">»</a></li>';
        
        echo '                  </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            ';
    }
    else echo '<div class="alert alert-warning"><strong>Нет существующих товаров</strong></div>';
    }
    if ($action=='create'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Добавление товаров
                    </h1>
                </div>
            </div>
        ';
        if (isset($_POST['tovarnewison'])){
            if (!$goodcreate) echo'<div class="alert alert-danger"><strong>Ошибка при добавлении!</strong> Возможно, вы заполнили не все поля</div>';
        }
        echo'
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            '; $select = 'SELECT * FROM  `tovar` ORDER BY  `tovar`.`id` DESC LIMIT 1'; $query = mysqli_query($db_server,$select); $row = mysqli_fetch_assoc($query); $n=$row['id']+1; echo'
                            <form method="POST" action="admin.php?page=tovar&action=create&id='.$n.'">
                                <div class="form-group">
                                    <label>Название товара</label>
                                    <input required class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Описание</label>
                                    <textarea row="5" required class="form-control" name="big"></textarea> 
                                </div>
                                <div class="form-group">
                                    <label>Длина</label>
                                    <input class="form-control" name="a">
                                </div>
                                <div class="form-group">
                                    <label>Ширина</label>
                                    <input class="form-control" name="b">
                                </div>
                                <div class="form-group">
                                    <label>Высота</label>
                                    <input class="form-control" name="c">
                                </div>
                                <div class="form-group">
                                    <label>Диаметр</label>
                                    <input class="form-control" name="d">
                                </div>
                                <div class="form-group">
                                    <label>Объем</label>
                                    <input class="form-control" name="v">
                                </div>
                                <div class="form-group">
                                    <label>Масса</label>
                                    <input class="form-control" name="m">
                                </div>
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select required name="category" class="form-control">
        '; 
        $select = 'SELECT * FROM `category`';
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        do{
            echo '<option>'.$row['name'].'</option>';
        } while($row = mysqli_fetch_assoc($query));
        echo'
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Подкатегория</label>
                                    <select required name="podcategory" class="form-control">
        '; 
        $select = 'SELECT * FROM `podcategory`';
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        do{
            echo '<option>'.$row['name'].'</option>';
        } while($row = mysqli_fetch_assoc($query));
        echo'
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Цена</label>
                                    <input required class="form-control" name="price">
                                </div>
                                <input type="submit" name="tovarnewison" class="btn btn-primary" value="Добавить">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    if ($action=='edit'){
      echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Редактирование товаров
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
        ';
        $select = 'SELECT * FROM `tovar`';
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        if ($row['id']>0){
            echo '
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover" width="100%" cellspacing="0" cellpadding="5">
                                    <tr>
                                        <th>№</th>
				                        <th><a href="admin.php?page=tovar&type=name">Название</a></th>
                                        <th><a href="admin.php?page=tovar&type=price">Цена</a></th>
                                        <th><a href="admin.php?page=tovar&type=category">Категория</a></th>
                                        <th><a href="admin.php?page=tovar&type=podcategory">Подкатегория</a></th>
                                        <th>Изменение изображений</th>
                                        <th>Изменение цен</th>
                                        <th>Изменить</th>
                                        <th>Удалить</th>
                                    </tr>                        
            ';
            $i=1;
            do{
                echo '<tr><td>'.$i.'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>от '.$row['price'].'</td>';
                echo '<td>'.$row['category'].'</td>';
                echo '<td>'.$row['podcat'].'</td>';
                echo '<td><a class="btn btn-info" href="admin.php?page=tovar&action=photothis&id='.$row['id'].'"><i class="fa fa-file-o"></i> Изменить</a></td>';
                echo '<td><a class="btn btn-primary" href="admin.php?page=tovar&action=costthis&id='.$row['id'].'"><i class="fa fa-money"></i> Изменить</a></td>';
                echo '<td><a class="btn btn-warning" href="admin.php?page=tovar&action=editthis&id='.$row['id'].'"><i class="fa fa-edit"></i> Изменить</a></td>';
                echo '<td><a class="btn btn-danger" href="admin.php?page=tovar&action=del&id='.$row['id'].'"><i class="fa fa-trash-o"></i> Удалить</a></td></tr>';
                $i++;
            } while($row = mysqli_fetch_assoc($query));
        echo '                  </table>
                            </div>
                        </div> 
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-8">
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-danger" href="admin.php?page=tovar&action=delall"><i class="fa fa-trash-o "></i> Удалить все товаров </a>
                        </div>
                    </div>
                </div>
        ';
        }
        else echo '<div class="alert alert-warning"><strong>Нет существующих товаров</strong></div>';
        echo'
            </div>
        ';
    }
    if ($action=='editthis'){
       echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Изменение товаров
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
        ';
        $select = 'SELECT * FROM `tovar` WHERE  `id` ='.$_GET['id'];
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        echo '
                            <form method="POST" action="admin.php?page=tovar&action=view&edit=ok&id='.$_GET['id'].'">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input class="form-control" name="name" value="'.$row['name'].'">
                                </div>
                                <div class="form-group">
                                    <label>Описание</label>
                                    <textarea row="5" required class="form-control" name="big">'.$row['big'].'</textarea> 
                                </div>
                                <div class="form-group">
                                    <label>Длина</label>
                                    <input class="form-control" name="a" value="'.$row['a'].'">
                                </div>
                                <div class="form-group">
                                    <label>Ширина</label>
                                    <input class="form-control" name="b" value="'.$row['b'].'">
                                </div>
                                <div class="form-group">
                                    <label>Высота</label>
                                    <input class="form-control" name="c" value="'.$row['c'].'">
                                </div>
                                <div class="form-group">
                                    <label>Диаметр</label>
                                    <input class="form-control" name="d" value="'.$row['d'].'">
                                </div>
                                <div class="form-group">
                                    <label>Объем</label>
                                    <input class="form-control" name="v" value="'.$row['v'].'">
                                </div>
                                <div class="form-group">
                                    <label>Масса</label>
                                    <input class="form-control" name="m" value="'.$row['m'].'">
                                </div>
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select required name="category" class="form-control">
        '; 
        $select = 'SELECT * FROM `category`';
        $qu = mysqli_query($db_server,$select);
        $r = mysqli_fetch_assoc($qu); 
        do{
            if ($r['name']==$row['category']) echo '<option selected="selected">'.$r['name'].'</option>';
                else echo '<option>'.$r['name'].'</option>';
        } while($r = mysqli_fetch_assoc($qu));
        echo'
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Подкатегория</label>
                                    <select required name="podcategory" class="form-control">
        '; 
        $select = 'SELECT * FROM `podcategory`';
        $qu = mysqli_query($db_server,$select);
        $r = mysqli_fetch_assoc($qu); 
        do{
            if ($r['name']==$row['podcat']) echo '<option selected="selected">'.$r['name'].'</option>';
                else echo '<option>'.$r['name'].'</option>';
        } while($r = mysqli_fetch_assoc($qu));
        echo'
                                    </select>
                                </div>
                                <input type="submit" name="editison" class="btn btn-primary" value="Сохранить">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    if ($action=='photothis'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Редактирование фотографий
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body"> 
        ';
        $select = 'SELECT * FROM `tovar` WHERE  `id` ='.$_GET['id'];
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        if ($gooddelphoto) echo '<div class="alert alert-success"><strong>Удаление произошло успешно!</strong></div>';
        if ($gooddelallphoto) echo '<div class="alert alert-success"><strong>Все фотографии удалены!</strong></div>';
        if ($row['photo'] > 0){
            $dir='../images/'.$_GET['id'].'/';
            $images = scandir($dir);
            echo '<table class="table table-hover" width="100%" cellspacing="0" cellpadding="5">
                                    <tr>
				                        <th width="50%">Фото</th>
                                        <th width="50%">Удалить</th>
                                    </tr>                        ';
            for ($i=2; $i < count($images); $i++){
                if (file_exists($dir.$images[$i]))
                    echo '
                            <tr>
                                <td>    
                                    <div class="col-xs-6">
                                        <img style="max-width:100%" src="'.$dir.$images[$i].'" alt="" />
                                    </div>
                                </td>
                                <td>
                                    <a class="btn btn-danger" href="admin.php?page=tovar&action=delthisphoto&id='.$row['id'].'&namephoto='.$images[$i].'"><i class="fa fa-trash-o"></i> Удалить</a>
                                </td>
                            </tr>
                    ';
            }
            echo '</table>';
        }
        else echo '<div class="alert alert-warning"><strong>Нет фотографий</strong></div>';
        echo '
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn btn-primary" href="admin.php?page=tovar&action=newphoto&id='.$_GET['id'].'"><i class="fa fa-plus"></i>Добавить фото</a>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn btn-danger" href="admin.php?page=tovar&action=delallphoto&id='.$_GET['id'].'"><i class="fa fa-trash-o"></i>Удалить все</a>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn btn-success" href="admin.php?page=tovar&action=costthis&id='.$_GET['id'].'"> Перейти к ценам <i class="fa fa-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
        ';

        echo ' 
                        </div>
                    </div>
                </div>
            </div>
        '; 
    }
    if ($action=='newphoto'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Добавление фотографий
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="POST" action="admin.php?page=tovar&action=photothis&id='.$_GET['id'].'" ENCTYPE="multipart/form-data">
                                <div class="form-group">
                                    <label>Добавить изображение</label>
                                    <input type="file" name="userfile">
                                </div>
                                <input type="submit" name="imagesnewison" class="btn btn-primary" value="Добавить">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    if ($action=="costthis"){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Редактирование цен
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body"> 
        ';
        if ($gooddelcostall)  echo'<div class="alert alert-success"><strong>Критерии успешно удалены!</strong></div>';
        if ($delcost)  echo'<div class="alert alert-success"><strong>Критерий успешно удален!</strong></div>';
        if ($goodcreatecost) echo'<div class="alert alert-success"><strong>Критерий успешно создан!</strong></div>';
        $select = 'SELECT * FROM `costs` WHERE  `idoftovar` ='.$_GET['id'];
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        if ($gooddelcost) echo '<div class="alert alert-success"><strong>Удаление произошло успешно!</strong></div>';
        if ($gooddelallcost) echo '<div class="alert alert-success"><strong>Все параметры цены удалены!</strong></div>';
        if ($row['id'] > 0){
            echo '<table class="table table-hover" width="100%" cellspacing="0" cellpadding="5">
                                    <tr>
				                        <th>Название</th>
                                        <th>Значение параметра</th>
                                        <th>Изменение цены</th>
                                        <th>Удалить</th>
                                    </tr>                        ';
        do{
                echo '<tr><td>'.$row['name'].'</td>';
                echo '<td>'.$row['type'].'</td>';
                echo '<td>'.$row['plus'].'</td>';
                echo '<td><a class="btn btn-danger" href="admin.php?page=tovar&action=delc&id='.$_GET['id'].'&name='.$row['id'].'"><i class="fa fa-trash-o"></i> Удалить</a></td></tr>';
            } while($row = mysqli_fetch_assoc($query));    
            echo '</table>';
        }
        else echo '<div class="alert alert-warning"><strong>Нет критериев</strong></div>';
        echo '
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-3">
                                            </div>
                                            <div class="col-md-3">
                                                <a class="btn btn-primary" href="admin.php?page=tovar&action=newcost&id='.$_GET['id'].'"><i class="fa fa-plus"></i> Добавить критерий</a>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn btn-danger" href="admin.php?page=tovar&action=delallcost&id='.$_GET['id'].'"><i class="fa fa-trash-o"></i> Удалить все</a>
                                            </div>
                                            <div class="col-md-2">
                                                <a class="btn btn-success" href="admin.php?page=tovar&action=photothis&id='.$_GET['id'].'"> Перейти к фотографиям <i class="fa fa-long-arrow-right"></i></a>
                                            </div>
                                        </div>
                                    </div>
        ';

        echo ' 
                        </div>
                    </div>
                </div>
            </div>
        '; 
    }
    if ($action=='newcost'){
         echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Добавление критериев
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <form method="POST" action="admin.php?page=tovar&action=costthis&id='.$_GET['id'].'">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input required class="form-control" name="type"> 
                                </div>
                                <div class="form-group">
                                    <label>Значение критерия</label>
                                    <input required class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>Изменение цены</label>
                                    <input required class="form-control" name="plus">
                                </div>
                                <input type="submit" name="costsnewison" class="btn btn-primary" value="Добавить">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
?>