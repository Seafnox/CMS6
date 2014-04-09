<?php


class ErrorForm extends CFormModel
{
	public $username;
	public $email;
	public $text;

        public $server_info;
	
        
        public function init() {
            
            $this->server_info = var_export($_SERVER, true);
            
        }
        
        
        /**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			
                        array('username, email', 'required'),
			array('email', 'email'),
                        array('text', 'safe'),
			
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'username'=>Yii::t('app', 'Username'),
                        'email' => Yii::t('app', 'Email'),
			'text' => Yii::t('app', 'Describe problem'),
		);
	}

        
      
	
}
