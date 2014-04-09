<?php

/**
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $role
 * @property string $name
 * @property string $image
 * @property string $phone
 * @property string $text
 */
class User extends CActiveRecord {

    /**
     * @var string роль по умолчанию
     */

    public $defaultRole = 'user';

    /**
     * @var string подтверждение пароля
     */

    public $confirm_password;

    /**
     * @var string предыдущий пароль
     */

    public $_password;


    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Users the static model class
     */

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'users';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, password, email, confirm_password, role', 'required'),
            array('email', 'unique', 'allowEmpty' => false, 'caseSensitive' => false, 'attributeName' => 'email', 'className' => 'User'),
            array('username', 'match', 'pattern' => '/^([a-z0-9_-])+$/'),
            array('username', 'unique', 'allowEmpty' => false, 'caseSensitive' => false, 'attributeName' => 'username', 'className' => 'User'),
            array('confirm_password', 'compare', 'compareAttribute' => 'password'),
            array('username, password, email', 'length', 'max' => 128),
            array('name', 'length', 'max' => 256),
            array('phone', 'length', 'max' => 16),
            array('text, image', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, password, email, role, name, image, phone, text', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
      
        return array(
            'sections'=>array(self::HAS_MANY, 'Section', 'author_id'), // Связь с категориями
         );
    }

        public function behaviors(){
          return array( 
                       
              'UploadableFileBehavior'=>array(
                    'class'=>'application.extensions.UploadableFileBehavior',
                    'attributeName'=>'image',
                  ),

              'permission'=>array(
                  'class'=>'application.modules.main.components.PermissionBehavior',
               ),

          );
          }
    
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'username' => Yii::t('app', 'Username'),
            'password' => Yii::t('app', 'Password'),
            'confirm_password' => Yii::t('app', 'Confirm password'),
            'email' => Yii::t('app', 'Email'),
            'role' => Yii::t('app', 'Role'),
            'name' => Yii::t('app', 'Name'),
            'image' => Yii::t('app', 'Image'),
            'phone' => Yii::t('app', 'Phone'),
            'text' => Yii::t('app', 'Text'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.username', $this->username, true);
        $criteria->compare('t.password', $this->password, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.role', $this->role, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.phone', $this->phone, true);
        $criteria->compare('t.text', $this->text, true);


        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                    ));
    }

    /**
     * Вызывается после инстацирования объекта
     */
    protected function afterFind() {

        $this->_password = $this->password;

        $this->confirm_password = $this->password;

        return parent::afterFind();
    }

    protected function beforeValidate() {

        /*
         * Если пользователь не имеет права изменять роль, то мы должны
         * установить роль по-умолчанию (user либо realtor)
         */
        if (!Yii::app()->user->checkAccess('changeRole')) {

            if ($this->isNewRecord) {
                //ставим роль по-умолчанию user либо realtor
                $this->role = $this->defaultRole;
            } else {
                $this->role = null;
            }

        }

        return parent::beforeValidate();
    }

    /*
     * Вызывается перед сохоанением объекта
     */

    protected function beforeSave() {

        if ($this->_password != $this->password) {
            $this->password = md5($this->password);
        }

        return parent::beforeSave();
    }

    /**
     * Возвращает список существующих ролей
     * @return array
     */

    public function getRoles() {

        $arr = array();

        $roles = Yii::app()->authManager->getRoles();

        foreach($roles AS $k=>$v)
            $arr[$k] = $k;

        return $arr;

    }
        


}