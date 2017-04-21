<?php
    session_start();
    if ($_GET['user']=='exit') {
        session_destroy();
        header('Location: admin.php?page=login');
    }
    if(!isset($_SESSION['history'])) $_SESSION['history']=array();
    ini_set('session.gc_maxlifetime', 9800);
    include('connect.php'); //ПОДКЛЮЧЕНИЕ К БД
    $page=$_GET['page'];
    $salt = '$2a$10$'.substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(),mt_rand()))), 0, 22) . '$';

    if ((isset($_POST['username']))&&(isset($_POST['password']))){
        $sql = 'SELECT * 
				FROM `users`
				WHERE `login` = "'.$_POST['username'].'"
				AND `admin` = 1';
        $res = mysqli_query($db_server,$sql);
        if(mysqli_num_rows($res) > 0){
            $row = mysqli_fetch_assoc($res);
            
            if(md5(md5($_POST['password']).$row['salt']) == $row['password'])
				$_SESSION['admin'] = true;
			else $bedpass=true; 
        }
		else
			$bedpass=true;
	}
    if (isset($_POST['loginison'])){
        $edit = 'UPDATE `users` SET `login`=\''.htmlspecialchars($_POST['username']).'\' WHERE `id`= 1;';
        $query = mysqli_query($db_server, $edit);
        $goodlog=true;
    }
    if (isset($_POST['passison'])){
        if ($_POST['password']==$_POST['spassword']){
            $edit = 'UPDATE `users` SET `password`=\''.md5(md5($_POST['password']).$row['salt']).'\' WHERE `id`= 1;';
            $query = mysqli_query($db_server, $edit);
            $goodpass=true;
        }
    }
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Административная панель</title>
        <!-- Bootstrap Styles-->
        <link href="../assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FontAwesome Styles-->
        <link href="../assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Morris Chart Styles-->
        <link href="../assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- Custom Styles-->
        <link href="../assets/css/custom-styles.css" rel="stylesheet" />
        <!-- Google Fonts-->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head>
    <body>
    <?php
        if (($_SESSION['admin'])&&(!isset($page))) $page='trueadmin';
        if (!$_SESSION['admin']) $page='login';
            
        if (($page=='login')&&(!$_SESSION['admin'])) {
            echo'
                <!-- ВХОД В АДМИНКУ -->
                <div class="col-lg-3">
                </div>
                <div class="col-lg-6">
                    <div class="panel panel-default form-group">
                        <div class="panel-body">
                            '; if ($bedpass) echo '<div class="alert alert-danger"><strong>Неверный логин или пароль!</strong></div>'; echo'
                            <form method="post" class="form" action="admin.php">
                                <p>
                                    <label for="username" class="uname" data-icon="u" > Логин</label>
                                    <input class="form-control" id="username" name="username" required="required" type="text" placeholder="Введите логин администратора"/>
                                </p>
                                <p>
                                    <label for="password" class="youpasswd" data-icon="p">  Пароль</label>
                                    <input class="form-control" id="password" name="password" required="required" type="password" placeholder="Введите пароль администратора" />
                                </p>
                                <p>
                                    <input type="submit" class="btn btn-primary" id="button" value="Войти" />
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                </div>
                <!-- ВХОД В АДМИНКУ -->
            ';
        }
           
        if ($_SESSION['admin']) {
            echo '<div id="wrapper">
                    <nav class="navbar navbar-default top-navbar" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <a class="navbar-brand" href="admin.php"><strong>'; 
                                                                                $select = 'SELECT * FROM  `sitinfo`  WHERE  `id` =1';
                                                                                $query = mysqli_query($db_server,$select);
                                                                                $row = mysqli_fetch_assoc($query);
                                                                                echo $row['znach'];
                                                                                echo '</strong></a>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li class="dropdown">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-user">
                                    <li>
                                        <a href="admin.php?page=option"><i class="fa fa-gear fa-fw"></i>Настройки</a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="admin.php?user=exit"><i class="fa fa-sign-out fa-fw"></i>Выйти</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </nav>
                    <!-- NAV TOP  -->
                    <nav class="navbar-default navbar-side" role="navigation">
                        <div class="sidebar-collapse">
                            <ul class="nav" id="main-menu">
                                <li>
                                    <a '; if ($page=='trueadmin') echo 'class="active-menu"'; echo' href="admin.php?page=trueadmin"><i class="fa fa-bar-chart-o"></i> Статистика</a>
                                </li>
                                <li>
                                    <a '; if ($page=='set') echo 'class="active-menu"'; echo' href="admin.php?page=set"><i class="fa fa-desktop"></i> Основные настройки</a>
                                </li>
                                <li>
                                    <a '; if ($page=='rubs') echo 'class="active-menu"'; echo' href="admin.php?page=rubs"><i class="fa fa-sitemap"></i> Категории <span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="admin.php?page=rubs&action=view">Просмотр</a>
                                        </li>
                                        <li>
                                            <a href="admin.php?page=rubs&action=create">Добавить</a>
                                        </li>
                                        <li>
                                            <a href="admin.php?page=rubs&action=edit">Изменить</a>
                                        </li> 
                                    </ul>
                                </li>
                                <li>
                                    <a '; if ($page=='podcat') echo 'class="active-menu"'; echo' href="admin.php?page=podcat"><i class="fa fa-qrcode"></i> Подкатегории <span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="admin.php?page=podcat&action=view">Просмотр</a>
                                        </li>
                                        <li>
                                            <a href="admin.php?page=podcat&action=create">Добавить</a>
                                        </li>
                                        <li>
                                            <a href="admin.php?page=podcat&action=edit">Изменить</a>
                                        </li> 
                                    </ul>
                                </li> 
                                <li>
                                    <a '; if ($page=='tovar') echo 'class="active-menu"'; echo' href="admin.php?page=tovar"><i class="fa fa-table"></i>   Товары <span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="admin.php?page=tovar&action=view">Просмотр</a>
                                        </li>
                                        <li>
                                            <a href="admin.php?page=tovar&action=create">Добавить</a>
                                        </li>
                                        <li>
                                            <a href="admin.php?page=tovar&action=edit">Изменить</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <!-- /. NAV SIDE  -->';
            
            echo '
                <div id="page-wrapper">
                    <div id="page-inner">
            ';
            
            if ($page=='option') {
                echo'
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="page-header">
                                    Настройки пользователя
                                </h1>
                            </div>
                        </div>
                ';
                if ($goodlog) echo'<div class="alert alert-success"><strong>Логин успешно изменен!</strong></div>';
                if ($goodpass) echo'<div class="alert alert-success"><strong>Пароль успешно изменен!</strong></div>';
                echo '
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        Изменение логина администратора
                                    </div>
                                    <div class="panel-body">
                                        <form method="POST" action="admin.php?page=option&action=login">
                                            <div class="form-group">
                                                <label>Логин</label>
                                                <input class="form-control" name="username">
                                            </div>
                                            <input type="submit" name="loginison" class="btn btn-primary" value="Изменить">
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <div class="panel-heading">
                                            Изменение пароля администратора
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <form method="POST" action="/admin.php?page=option&action=password">
                                            <div class="form-group">
                                                <label>Введите новый пароль</label>
                                                <input type="password" class="form-control" name="password">
                                            </div>
                                            <div class="form-group">
                                                <label>Повторите новый пароль</label>
                                                <input type="password" class="form-control" name="spassword">
                                            </div>
                                            <input type="submit" name="passison" class="btn btn-primary" value="Изменить">
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
        ';
            }
            if ($page=='set') { include'set.php'; }
            if ($page=='rubs') { include'rubs.php'; }
            if ($page=='podcat') { include'podcat.php'; }
            if ($page=='trueadmin') { include'trueadmin.php'; }
            if ($page=='tovar'){ include'tovar.php'; }

            echo '
                    </div>
                </div>
            ';
        
            echo '
                </div>
                <!-- /. PAGE INNER  -->
            </div>
            <!-- /. PAGE WRAPPER  -->
        </div>
        <!-- /. WRAPPER  --> 
        <!-- JS Scripts-->
        <!-- jQuery Js -->
        <script src="../assets/js/jquery-1.10.2.js"></script>
        <!-- Bootstrap Js -->
        <script src="../assets/js/bootstrap.min.js"></script>	 
        <!-- Metis Menu Js -->
        <script src="../assets/js/jquery.metisMenu.js"></script>
        <!-- Morris Chart Js -->
        <script src="../assets/js/morris/raphael-2.1.0.min.js"></script>
        <script src="../assets/js/morris/morris.js"></script>
        <script src="../assets/js/easypiechart.js"></script>
        <script src="../assets/js/easypiechart-data.js"></script>
        <!-- Custom Js -->
        <script src="../assets/js/custom-scripts.js"></script>';
        }
    ?>
    </body>
</html>