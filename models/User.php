<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property string $uid
 * @property string $nickname
 * @property string $mobile
 * @property string $email
 * @property integer $sex
 * @property string $avatar
 * @property string $login_name
 * @property string $login_pwd
 * @property string $login_salt
 * @property integer $status
 * @property string $updated_time
 * @property string $created_time
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex', 'status'], 'integer'],
            [['updated_time', 'created_time'], 'safe'],
            [['nickname', 'email'], 'string', 'max' => 100],
            [['mobile', 'login_name'], 'string', 'max' => 20],
            [['avatar'], 'string', 'max' => 64],
            [['login_pwd', 'login_salt'], 'string', 'max' => 32],
            [['login_name'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => '用户uid',
            'nickname' => '用户名',
            'mobile' => '手机号码',
            'email' => '邮箱地址',
            'sex' => '1：男 2：女 0：没填写',
            'avatar' => '头像',
            'login_name' => '登录用户名',
            'login_pwd' => '登录密码',
            'login_salt' => '登录密码的随机加密秘钥',
            'status' => '1：有效 0：无效',
            'updated_time' => '最后一次更新时间',
            'created_time' => '插入时间',
        ];
    }

    // 生成加密 密码
    public function getSaltPassword( $password )
    {
        return md5( $password. md5( $this->login_salt ) );
    }

    // 校验加密 密码
    public function verifyPassword( $password )
    {
       $verify_pwd =  $this->getSaltPassword( $password ) ;
   
        if( $verify_pwd != $this->login_pwd )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    // 设置密码
    public function setPassword( $password )
    {
        $this->login_pwd = $this->getSaltPassword( $password );
    }

    // 生成密码随机key
    public function setSalt()
    {
        $chars = 'qazwxedcrfvtgbyhnujmikolpQAZWSXEDCRFVTGBYHNUJMIKOLP!@#$%^&*';
        
        $salt = '';

        for ($i=0; $i <= 6 ; $i++) { 
            
            $salt .= $chars[ mt_rand( 0, strlen( $chars )-1 ) ]; 
        }

        $this->login_salt = $salt;
    }







}
