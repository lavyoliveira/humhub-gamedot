<?php

use humhub\modules\user\widgets\Image;
use yii\helpers\Html;
use humhub\widgets\GridView;
use humhub\modules\space\modules\manage\widgets\MemberMenu;
?>

<div class="panel panel-default">
    <div class="panel-heading">
        <?= Yii::t('SpaceModule.manage', '<strong>Manage</strong> members'); ?>
    </div>
    <?= MemberMenu::widget(['space' => $space]); ?>
    <div class="panel-body">
        <div class="table-responsive">
            <?php
            $groups = $space->getUserGroups();

            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'format' => 'raw',
                        'value' => static function ($model) {
                            return Image::widget(['user' => $model->user, 'width' => 25]);
                        }
                    ],
                    'user.username',
                    'user.profile.firstname',
                    'user.profile.lastname',
                    'request_message',
                    [
                        'header' => Yii::t('SpaceModule.manage', 'Actions'),
                        'class' => 'yii\grid\ActionColumn',
                        'buttons' => [
                            'view' => function() {
                                return;
                            },
                            'delete' => function ($url, $model) use ($space) {
                                return Html::a('Reject', $space->createUrl('reject-applicant', ['userGuid' => $model->user->guid]), ['class' => 'btn btn-danger btn-sm', 'data-method' => 'POST']);
                            },
                            'update' => function ($url, $model) use ($space) {
                                return Html::a('Approve', $space->createUrl('approve-applicant', ['userGuid' => $model->user->guid]), ['class' => 'btn btn-primary btn-sm', 'data-method' => 'POST']);
                            },
                        ],
                    ],
                ],
            ]);
            ?>
        </div>
    </div>
</div>
