<?php
use yii\helpers\Html;
use yii\widgets\LinkPager;
?>
<h1>Donation</h1>
<ul>
<?php foreach ($donations as $donation): ?>
    <li>
        <?php echo $donation->name; ?>
    </li>
<?php endforeach; ?>
</ul>
<?= LinkPager::widget(['pagination' => $pagination]) ?>