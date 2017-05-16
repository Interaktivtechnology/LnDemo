<?php
use yii\helpers\Url;
use yii\base\View;
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'Account';
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-binoculars"></i>Object Viewer', 'url' => ['/objectviewer'], 'encode'=>false];
$this->params['breadcrumbs'][] = ['label' => '<i class="fa fa-genderless"></i>'.$this->title, 'url' => ['/objectviewer'], 'encode'=>false];
?>

<div class="comm-import-log-index">
    <h2>Account</h2>
    <div class="table-responsive">
    
    <?= GridView::widget(['dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ]
    ]);
    ?>
     </div>
</div>