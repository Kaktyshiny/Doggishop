<?php
    function loga($number, $base) {
        return log($number) / log($base);
    }
    if (isset($_POST['fun'])){
        $str=$_POST['func'];
        $l= strlen($str);
        $num  = loga($l, 2);
        if (pow(2, $num) != $l) $er="Неправильные входные данные"; 
        else $res=1;
    }
?>
<!DOCTYPE HTML> 
<html>
    <head>
        <!-- Bootstrap Styles-->
        <link href="assets/css/bootstrap.css" rel="stylesheet" />
        <!-- FontAwesome Styles-->
        <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- Morris Chart Styles-->
        <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
        <!-- Custom Styles-->
        <link href="assets/css/custom-styles.css" rel="stylesheet" />
        <!-- Google Fonts--> 
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    </head> 
    <body>
        <div class="wrapper">
            <div class="row">
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Дискретная математика</h3>
                        </div>
                        <div class="panel-body">
                            <?php
                                if (isset($er)) echo '<div class="alert alert-danger"><strong>'.$er.'</strong></div>';
                            ?>
                            <form method="POST" action="math.php">
                                <div class="form-group">
                                    <label>Функция f(x)</label>
                                    <input class="form-control" name="func">
                                </div>
                                <input type="submit" name="fun" class="btn btn-primary" value="Узнать">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
<?php 
    if (isset($res)){
    echo'
            <div class="row">
                 <div class="col-lg-3"></div>
                <div class="col-lg-6"> 
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Предыдущий ответ</h3> 
                        </div>
                        <div class="panel-body">';
        //for ($i=0; $i<$l; $i++) echo '$str['.$i.'] = '.$str[$i].'<br>';
        if (pow(2, $num) == $l){
            $p=$l;
            $t1=$str;
            for ($i=0; $i<$num; $i++){
                $k=$p;
                $p=$p/2;
                $t2=substr($t1, $p , $k); 
                $t1=substr($t1, 0 , $p);            
                $flag=false;
                //echo '$p='.$p.'; <br> $k = '.$k.'; <br> $t1='.$t1.'; <br> $t2='.$t2.';<br>';
                if ($t1==$t2) $flag=true;
                if ($flag) echo 'x['.$i.'] - фиктивная <br>';
                else echo 'x['.$i.'] - существенная <br>';
            }
        } 
    echo'
                        </div>
                    </div>
                </div>
                <div class="col-lg-3"></div>
            </div>
    ';}
?>
        </div>
    </body>
</html>