<?php

/** @var yii\web\View $this */
/** @var \app\models\UploadForm $model */

/** @var array $fileLinesArr */

use yii\widgets\ActiveForm;

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <div class="row">
        <div class="col-12">
            <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <?= $form->field($model, 'imageFile')->fileInput() ?>

            <button class="btn btn-primary">Submit</button>

            <?php ActiveForm::end() ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php if ($fileLinesArr === false) { ?>
                <div class="circle red"></div>
            <?php } elseif (!empty($fileLinesArr)) { ?>
                <div class="circle green"></div>
                <div>
                    <ul>
                        <?php foreach ($fileLinesArr as $item) { ?>
                            <li><?= $item ?></li>
                        <?php } ?>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
