<?php

/**
 * @link https://www.humhub.org/
 * @copyright Copyright (c) 2016 HumHub GmbH & Co. KG
 * @license https://www.humhub.com/licences
 */

namespace humhub\modules\user\widgets;

use Yii;
use humhub\modules\user\models\User;

/**
 * Shows newly registered users as sidebar widget
 *
 * @since 0.11
 * @author Luke
 */
class NewMembers extends \yii\base\Widget
{

    /**
     * @var boolean show list all members button
     */
    public $showMoreButton = false;

    /**
     * @var boolean show invite new members button
     */
    public $showInviteButton;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $inviteAllowed = !Yii::$app->user->isGuest && Yii::$app->getModule('user')->settings->get('auth.internalUsersCanInvite');

        if ($this->showInviteButton === null) {
            $this->showInviteButton = $inviteAllowed;
        } elseif ($this->showInviteButton && !$inviteAllowed) {
            $this->showInviteButton = false;
        }

        parent::init();
    }

    /**
     * @inheritdoc
     */
    public function run()
    {
        $newUsers = User::find()->orderBy('created_at DESC')->visible()->limit(10);

        return $this->render('newMembers', [
                    'newUsers' => $newUsers->all(),
                    'showMoreButton' => $this->showMoreButton,
                    'showInviteButton' => $this->showInviteButton
        ]);
    }

}