<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var movieURL */

?>

<div class="movie-view">
    <video controls="" autoplay="" name="media" width="640" height="480">
    <?php
    echo '<source src="' . $movieURL . '"></video>'."\n";
	?>
</div>
