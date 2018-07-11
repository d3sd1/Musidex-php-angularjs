<?php
require('../kernel/core.php');
?>

<div class="page-err err-not-found">
    <div class="err-container">
        <div class="container-text text-center">
            <div class="err-status">
                 <h1><?php echo $lang['error.404.title'] ?></h1>
            </div>
            <div class="err-message">
                <h2><?php echo $lang['error.404.description'] ?></h2>
            </div>
        </div>
    </div>

    <div class="text-center err-body">
      <a href="#/" class="btn btn-lg btn-primary">
        <span class="glyphicon glyphicon-home"></span>
        <span class="space"></span>
        <?php echo $lang['error.back'] ?>
      </a>
    </div>

</div>