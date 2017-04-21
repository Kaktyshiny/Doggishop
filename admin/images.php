<?php 
    if (!isset($_GET['action'])) $action='view';
    else $action=$_GET['action'];
    if (!isset($_GET['type'])) $type='id';
    else $type=$_GET['type'];
    if (!isset($_GET['numb'])) $numb='0';
    else $numb=$_GET['numb'];


    if (isset($_POST['imagesnewison'])){
        $blacklist = array(".php", ".phtml", ".php3", ".php4");
        foreach ($blacklist as $item) {
            if(preg_match("/$item\$/i", $_FILES['userfile']['name'])) {
                $goodcreate = false;
                $mes= "Неверный формат";
                    exit;
            }
        }
        $uploaddir = '../images/';
        $uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

        if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
            $goodcreate = true;
            $tovar=$_POST['whicht'];
            $name=$_FILES['userfile']['name'];
            $select = "SELECT * FROM `tovar` WHERE  `name`=.$tovar.";
            $query = mysqli_query($db_server,$select);
            $row = mysqli_fetch_assoc($query);
            $id=$row['id'];
            $query="INSERT INTO `images` (name, tovar) VALUES('$name', '$id');"; 
            mysqli_query($db_server,$query); 
            $action='view';
       } else {
            $goodcreate = false;
            $mes= "Загрузка не удалась";
        }
    }
    if (isset($_POST['editison'])){
        $edit = 'UPDATE `images` SET `name`=\''.htmlspecialchars($_POST['name']).'\', `tname`=\''.htmlspecialchars($_POST['tname']).'\' WHERE `id`= '.$_GET['id'].';';
        $query = mysqli_query($db_server, $edit);
        $goodedit=true;
    }

    if ($action=='del'){
        $i=$_GET['id'];
		$query="DELETE FROM `images` WHERE id=$i"; 
		mysqli_query($db_server, $query); 
        $action='view';
        $gooddel=true;
    }
    if ($action=='delall'){
        $query="Truncate Table `images`";
		mysqli_query($db_server, $query);
        $action='view';
    }
    if ($action=='view'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Список категорий
                    </h1>
                </div>
            </div>
        ';
        if ((isset($_POST['imagesnewison']))||(isset($_POST['editison']))){
            if ($goodcreate) echo'<div class="alert alert-success"><strong>Рубрика успешно добавлена!</strong></div>';
            if ($goodedit) echo'<div class="alert alert-success"><strong>Рубрика успешно изменена!</strong></div>';
        }
        if ($gooddel) echo'<div class="alert alert-success"><strong>Рубрика успешно удалена!</strong></div>';
        echo'
            <div class="row">
                <div class="col-md-12">
        ';
        $select = 'SELECT * FROM `images`';
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
                                    </tr>                        
            ';
            $i=1;
            do{
                echo '<tr><td>'.$i.'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['tname'].'</td></tr>';
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
    else echo '<div class="alert alert-warning"><strong>Нет существующих категорий</strong></div>';
    }
    if ($action=='create'){
        echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Список категорий
                    </h1>
                </div>
            </div>
        ';
        if (isset($_POST['imagesnewison'])){
            if (!$goodcreate) echo'<div class="alert alert-danger"><strong>Ошибка при добавлении!</strong> Возможно, вы заполнили не все поля</div>';
        }
        echo'
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Добавление категории
                        </div>
                        <div class="panel-body">
                            <form method="POST" action="admin.php?page=images&action=create" ENCTYPE="multipart/form-data">
                                <div class="form-group">
                                    <label>Товар</label>
                                    <select name="whicht" class="form-control">
        ';
        $select = 'SELECT * FROM `tovar`';
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        do{
            echo '<option>'.$row['name'].'</option>';
        } while($row = mysqli_fetch_assoc($query));
        echo'
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>URL-name</label>
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
    if ($action=='edit'){
      echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Редактирование категорий
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
        ';
        $select = 'SELECT * FROM `images`';
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
                                        <th>Изменить</th>
                                        <th>Удалить</th>
                                    </tr>                        
            ';
            $i=1;
            do{
                echo '<tr><td>'.$i.'</td>';
                echo '<td>'.$row['name'].'</td>';
                echo '<td>'.$row['tname'].'</td>';
                echo '<td><a class="btn btn-warning" href="admin.php?page=images&action=editthis&id='.$row['id'].'"><i class="fa fa-edit "></i> Изменить</a></td>';
                echo '<td><a class="btn btn-danger" href="admin.php?page=images&action=del&id='.$row['id'].'"><i class="fa fa-trash-o"></i> Удалить</a></td></tr>';
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
                            <a class="btn btn-danger" href="admin.php?page=images&action=delallq"><i class="fa fa-trash-o "></i> Удалить все категории </a>
                        </div>
                    </div>
                </div>
        ';
        }
        else echo '<div class="alert alert-warning"><strong>Нет существующих категорий</strong></div>';
        echo'
            </div>
        ';
    }
    if ($action=='editthis'){
       echo'
            <div class="row">
                <div class="col-md-12">
                    <h1 class="page-header">
                        Изменение категории
                    </h1>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
        ';
        $select = 'SELECT * FROM `images` WHERE  `id` ='.$_GET['id'];
        $query = mysqli_query($db_server,$select);
        $row = mysqli_fetch_assoc($query);
        echo '
                            <form method="POST" action="admin.php?page=images&action=view&edit=ok&id='.$_GET['id'].'">
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