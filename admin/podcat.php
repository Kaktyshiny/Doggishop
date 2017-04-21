<?php 
    if (!isset($_GET['action'])) $action='view';
    else $action=$_GET['action'];
    if (!isset($_GET['type'])) $type='id';
    else $type=$_GET['type'];
    if (!isset($_GET['numb'])) $numb='0';
    else $numb=$_GET['numb'];


    if (isset($_POST['podcatnewison'])){
        if (($_POST['name']!='')&($_POST['tname']!='')) $goodcreate=true;
        if ($goodcreate) {
            $action='view';
            $name=$_POST['name'];
            $tname=$_POST['tname'];
            $category=$_POST['category'];
            $query="INSERT INTO `podcategory` (name, tname, category) VALUES('$name', '$tname', '$category');"; 
            mysqli_query($db_server,$query); 
        }
    }
    if (isset($_POST['editison'])){
        $edit = 'UPDATE `podcategory` SET `name`=\''.htmlspecialchars($_POST['name']).'\', `tname`=\''.htmlspecialchars($_POST['tname']).'\' WHERE `id`= '.$_GET['id'].';';
        $query = mysqli_query($db_server, $edit);
        $goodedit=true;
    }

    if ($action=='del'){
        $i=$_GET['id'];
        $select = 'SELECT * FROM `podcategory` WHERE  id='.$i;
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        $name=$row['name'];
		$query="DELETE FROM `podcategory` WHERE id=$i"; 
		mysqli_query($db_server, $query); 
        $query="DELETE FROM  `tovar`  WHERE  `podcategory` =  '$name'";
		mysqli_query($db_server, $query);
        $action='view';
        $gooddel=true;
    }
    if ($action=='delall'){
        $query="Truncate Table `podcategory`";
		mysqli_query($db_server, $query);
        $action='view';
    }
    if ($action=='view'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Список подкатегорий
                    </h1>
                </div>
            </div>
        ';
        if ((isset($_POST['podcatnewison']))||(isset($_POST['editison']))){
            if ($goodcreate) echo'<div class="alert alert-success"><strong>Рубрика успешно добавлена!</strong></div>';
            if ($goodedit) echo'<div class="alert alert-success"><strong>Рубрика успешно изменена!</strong></div>';
        }
        if ($gooddel) echo'<div class="alert alert-success"><strong>Рубрика успешно удалена!</strong></div>';
        echo'
            <div class="row">
                <div class="col-md-12">
        ';
        $select = 'SELECT * FROM `podcategory`';
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
				                        <th>Название</th>
				                        <th>URL-name</th>
                                        <th>Категория</th>
                                    </tr>                        
            ';
            $i=1;
            do{
                echo '<tr><td>'.$i.'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['tname'].'</td>';
                echo '<td>'.$row['category'].'</td></tr>';
                $i++;
            } while($row = mysqli_fetch_assoc($query));
            echo '                  </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            ';
    }
    else echo '<div class="alert alert-warning"><strong>Нет существующих подкатегорий</strong></div>';
    }
    if ($action=='create'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Список подкатегорий
                    </h1>
                </div>
            </div>
        ';
        if (isset($_POST['podcatnewison'])){
            if (!$goodcreate) echo '<div class="alert alert-danger"><strong>Ошибка при добавлении!</strong> Возможно, вы заполнили не все поля</div>';
        }
        echo'
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Добавление подкатегории
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="admin.php?page=podcat&action=create">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input class="form-control" name="name">
                                </div>
                                <div class="form-group">
                                    <label>URL-name</label>
                                    <input class="form-control" name="tname">
                                </div>
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select name="category" class="form-control">
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
                                <input type="submit" name="podcatnewison" class="btn btn-primary" value="Добавить">
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
                        Редактирование подкатегорий
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
        ';
        $select = 'SELECT * FROM `podcategory`';
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
                                        <th>Название</th>
                                        <th>URL-name</th>
                                        <th>Категория</th>
                                        <th>Изменить</th>
                                        <th>Удалить</th>
                                    </tr>                        
            ';
            $i=1;
            do{
                echo '<tr><td>'.$i.'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['tname'].'</td>';
                echo '<td>'.$row['category'].'</td>';
                echo '<td><a class="btn btn-warning" href="admin.php?page=podcat&action=editthis&id='.$row['id'].'"><i class="fa fa-edit "></i> Изменить</a></td>';
                echo '<td><a class="btn btn-danger" href="admin.php?page=podcat&action=del&id='.$row['id'].'"><i class="fa fa-trash-o"></i> Удалить</a></td></tr>';
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
                            <a class="btn btn-danger" href="admin.php?page=podcat&action=delallq"><i class="fa fa-trash-o "></i> Удалить все подкатегории </a>
                        </div>
                    </div>
                </div>
        ';
        }
        else echo '<div class="alert alert-warning"><strong>Нет существующих подкатегорий</strong></div>';
        echo'
            </div>
        ';
    }
    if ($action=='editthis'){
       echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Изменение подкатегории
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
        ';
        $select = 'SELECT * FROM `podcategory` WHERE  `id` ='.$_GET['id'];
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        echo '
                            <form method="POST" action="admin.php?page=podcat&action=view&edit=ok&id='.$_GET['id'].'">
                                <div class="form-group">
                                    <label>Название</label>
                                    <input class="form-control" name="name" value="'.$row['name'].'">
                                </div>
                                <div class="form-group">
                                    <label>URL-name</label>
                                    <input class="form-control" name="tname" value="'.$row['tname'].'">
                                </div>
                                <input type="submit" name="editison" class="btn btn-primary" value="Сохранить">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        ';
    }
    if ($action=='delallq'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Подтверждение удаления
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            
                        </div>
                    </div>
                </div>
            </div>';
    }
?>