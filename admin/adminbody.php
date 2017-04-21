<?php 
    echo '
        <div id="page-wrapper">
            <div id="page-inner">
    ';

    if ($page=='set') { include'set.php'; }
    if ($page=='rubs') { include'rubs.php'; }
    if ($page=='trueadmin') { include'trueadmin.php'; }
    if ($page=='tovar'){ include'tovar.php'; }

    echo '
            </div>
        </div>
    ';
?>