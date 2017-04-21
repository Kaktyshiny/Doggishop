<div class="container">
    <?php
    $select = 'SELECT * FROM `sitinfo`';
    $query = mysqli_query($db_server,$select);
    $row = mysqli_fetch_assoc($query);
    $row = mysqli_fetch_assoc($query);
    $row = mysqli_fetch_assoc($query);
    echo '<p>Адрес: '.$row['znach'].'</p>';
    $row = mysqli_fetch_assoc($query);
    echo '<p>Телефон:'.$row['znach'].'</p>';
    $row = mysqli_fetch_assoc($query);
    echo '<p>Дополнительный телефон:'.$row['znach'].'</p>';
    $row = mysqli_fetch_assoc($query);
    echo '<p>Адрес электронной почты:'.$row['znach'].'</p>';
    ?>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2243.6739189767786!2d37.70911101605393!3d55.78153498056106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46b5356dcb93f63b%3A0x320fe585579bf583!2z0JHQvtC70YzRiNCw0Y8g0KHQtdC80LXQvdC-0LLRgdC60LDRjyDRg9C7LiwgMzgsINCc0L7RgdC60LLQsCwgMTA3MDIz!5e0!3m2!1sru!2sru!4v1482744883361" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>