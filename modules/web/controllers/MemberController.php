<?php 
namespace app\modules\web\controllers;

use yii\web\Controller;
use app\modules\web\controllers\common\BaseWebController;


class MemberController extends BaseWebController
{
	/**
     * 会员列表
     * @return string
     */
	public function actionIndex()
	{
        return $this->render('index');
	}

	/**
     * 会员详情
     * @return string
     */
	public function actionInfo()
	{
        return $this->render('info');
	}

	/**
     * 会员添加或者编辑
     * @return string
     */
	public function actionSet()
	{
        return $this->render('set');
	}

	/**
     * 会员评论
     * @return string
     */
	public function actionComment()
	{
        return $this->render('comment');
	}
}


 ?>

