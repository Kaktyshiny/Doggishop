<?php
 
    //ОБРАБОТКА ВХОДНЫХ ДАННЫХ
    if (isset($_POST['setison'])) {    
        if ($_POST['name']!='') {
            $edit = 'UPDATE `sitinfo` SET `znach`=\''.htmlspecialchars($_POST['name']).'\' WHERE `id`= 1;';
            $query = mysqli_query($db_server, $edit);
        }
        if ($_POST['tegs']!='') {
            $edit = 'UPDATE `sitinfo` SET `znach`=\''.htmlspecialchars($_POST['tegs']).'\' WHERE `id`= 2;';
            $query = mysqli_query($db_server, $edit);
        }
        if ($_POST['adress']!='') {
            $edit = 'UPDATE `sitinfo` SET `znach`=\''.htmlspecialchars($_POST['adress']).'\' WHERE `id`= 3;';
            $query = mysqli_query($db_server, $edit);
        }
        if ($_POST['tel']!='') {
            $edit = 'UPDATE `sitinfo` SET `znach`=\''.htmlspecialchars($_POST['tel']).'\' WHERE `id`= 4;';
            $query = mysqli_query($db_server, $edit);
        }
        if ($_POST['stel']!='') {
            $edit = 'UPDATE `sitinfo` SET `znach`=\''.htmlspecialchars($_POST['stel']).'\' WHERE `id`= 5;';
            $query = mysqli_query($db_server, $edit);
        }
        if ($_POST['email']!='') {
            $edit = 'UPDATE `sitinfo` SET `znach`=\''.htmlspecialchars($_POST['email']).'\' WHERE `id`= 6;';
            $query = mysqli_query($db_server, $edit);
        }
    }
    //КОНЕЦ ОБРАБОТКИ ВХОДНЫХ ДАННЫХ

$select = 'SELECT * FROM `sitinfo` WHERE  `active` =1';
$query = mysqli_query($db_server,$select);
$row = mysqli_fetch_assoc($query);


    echo'
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                    Основные настройки
                </h1>
        </div>
    ';
    
    echo'
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Настройки названия и адреса.
                </div>
                <div class="panel-body">
                    <form method="POST" action="admin.php?page=set">
                        <div class="col-lg-6">
                           <div class="form-group">
                                <label>'.$row['name'].'</label>
                                <input class="form-control" name="name" placeholder="'.$row['znach'].'">
                                '; $row = mysqli_fetch_assoc($query); echo'
                           </div>
                           <div class="form-group">
                                <label>'.$row['name'].'</label>
                                <textarea rows="2" class="form-control" name="tegs" placeholder="'.$row['znach'].'"></textarea>
                                '; $row = mysqli_fetch_assoc($query); echo'
                           </div>
                           <div class="form-group">
                                <label>'.$row['name'].'</label>
                                <input class="form-control" name="adress" placeholder="'.$row['znach'].'">
                                '; $row = mysqli_fetch_assoc($query); echo'
                           </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>'.$row['name'].'</label>
                                <input class="form-control" name="tel" placeholder="'.$row['znach'].'">
                                '; $row = mysqli_fetch_assoc($query); echo'
                            </div>
                            <div class="form-group">
                                <label>'.$row['name'].'</label>
                                <input class="form-control" name="stel" placeholder="'.$row['znach'].'">
                                '; $row = mysqli_fetch_assoc($query); echo'
                            </div>
                            <div class="form-group">
                                <label>'.$row['name'].'</label>
                                <input class="form-control" name="email" placeholder="'.$row['znach'].'">
                                '; $row = mysqli_fetch_assoc($query); echo'
                           </div>
                            <div class="row">
                                <div class="col-lg-8">
                                </div>
                                <div class="col-lg-4">
                                    <input type="submit" name="setison" class="btn btn-primary" value="Сохранить">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    ';


?>