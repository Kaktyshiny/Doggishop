<?php
if (isset($_POST['newemail'])){
    $select = 'SELECT * FROM `sitinfo` WHERE `id`=6';
    $em=$row['znach'];
    $query = mysqli_query($db_server,$select);
    $row = mysqli_fetch_assoc($query);
    $x='';
    for ($i=1;$i<=$_SESSION['cart'];$i++){
        $x.=$_SESSION['zakaz'][$i];
    }
    $name=$_POST['name'];
    $email=$_POST['email'];
    $sum=$_SESSION['sum'];
    $x=htmlspecialchars($x);
    //$query="INSERT INTO `zakaz` (tovar, name, email) VALUES('lol','lol', 'lol');";
    //mysqli_fetch_assoc($query);
    //$select = 'SELECT * FROM  `zakaz` ORDER BY `id` DESC LIMIT 1'; 
    //$query = mysqli_query($db_server,$select); 
    //$row = mysqli_fetch_assoc($query);
    mail("kaktyshiny@gmail.com", "New order", "New order %) from $name");
    echo '<div class="alert alert-succes"><strong>Спасибо за заказ</strong></div>';
    $_SESSION['cart']=0;
    $_SESSION['sum']=0;
    $_SESSION['lastsum']=0;
}
?>
<div class="container">
    <label>Уточните ваши данные</label>
    <form method="post" action="index.php?page=form">
        <div class="form-group">
            <label>Ваше имя</label>
            <input required class="form-control" name="name"/>
        </div>
        <div class="form-group">
            <label>Ваш адрес электронной почты</label>
            <input required class="form-control" name="email"/>
        </div>
        <input type="submit" name="newemail" class="btn btn-warning"/>
    </form>
</div>