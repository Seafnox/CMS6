<?php

/**
 * Класс формы обратной связи
 */
class FeedbackForm extends CFormModel
{
    public $_code = "fr87ry9jr474g3f464gr874hi83254cx[t:";

    public $user_id;
    public $username;
    public $email;
    public $text;
    public $phone;
    public $code;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(

            array('username,email', 'required'),
            array('code', 'сheckVerifyCode'),
            array('email', 'email'),
            array('text, phone, user_id', 'safe'),

        );
    }


    public function сheckVerifyCode($attribute, $params)
    {
        if ($this->$attribute != $this->_code) {
            $this->addError($attribute, 'Не верен код проверки');
        }
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'username' => Yii::t('app', 'Username'),
            'email' => Yii::t('app', 'Email'),
            'text' => Yii::t('app', 'Text'),
            'phone' => Yii::t('app', 'Phone'),
        );
    }


}
