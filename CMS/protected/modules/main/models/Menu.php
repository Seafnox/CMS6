<?php

/**
 * This is the model class for table "menu".
 *
 * The followings are the available columns in table 'menu':
 * @property integer $id
 * @property string $title
 * @property string $code
 * @property string $link
 * @property string $target
 * @property integer $active
 * @property integer $section_id
 * @property integer $author_id
 * @property string $mtime
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $root
 */
class Menu extends CActiveRecord
{

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Menu the static model class
	 */
    public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * Таргеты для ссылок
     * @return array
     */

    public function getTargets() {

        return array(
            "_self" => Yii::t('app', 'Self window'),
            "_blank" => Yii::t('app', 'New window')
        );
    }

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
        // @TODO сделать проверку на уникальность свойства code

		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, code', 'required'),
			array('active, section_id', 'numerical', 'integerOnly'=>true),
			array('title, link', 'length', 'max'=>255),
			array('code, target', 'length', 'max'=>32),
            array('code', 'match', 'pattern' => '/^([a-z0-9_])+$/'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, code, link, target, active, section_id, author_id, mtime, lft, rft, level, root', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Поведения
     * @return array
     */

    public function behaviors()
    {
        return array(
            'nestedSetBehavior'=>array(
                'class'=>'application.components.NestedSetBehavior',
                'leftAttribute'=>'lft',
                'rightAttribute'=>'rgt',
                'levelAttribute'=>'level',
                'hasManyRoots'=>true
            ),
            'permission'=>array(
                'class'=>'application.modules.main.components.PermissionBehavior',
            ),
        );
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'section' => array(self::BELONGS_TO, 'Section', 'section_id'),
		);

    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => Yii::t('app', 'Title'),
			'code' => Yii::t('app','Code'),
			'link' => Yii::t('app','Link'),
			'target' => Yii::t('app','Target'),
			'active' => Yii::t('app','Active'),
			'section_id' => Yii::t('app','Section'),
			'author_id' => Yii::t('app','Author'),
			'mtime' => Yii::t('app','Mtime'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria = $this->getDbCriteria();

		$criteria->compare('id',$this->id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('target',$this->target,true);
		$criteria->compare('active',$this->active);
		$criteria->compare('section_id',$this->section_id);
		$criteria->compare('author_id',$this->author_id);
		$criteria->compare('mtime',$this->mtime,true);
		$criteria->compare('lft',$this->lft);
		$criteria->compare('rgt',$this->rgt);
		$criteria->compare('level',$this->level);
		$criteria->compare('root',$this->root);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


    public function getBredCrumbsArr($parent_id, $route) {

        if(empty($parent_id))
            return array();

        $model=Menu::model()->findByPk($parent_id);

        $descendants = $model->ancestors()->findAll();

        $arr = array();

        foreach($descendants AS $parent) {

            $arr[$parent->title] = Yii::app()->getUrlManager()->createUrl($route, array("parent_id" => $parent->id));

        }

        $arr[$model->title] = Yii::app()->getUrlManager()->createUrl($route, array("parent_id" => $model->id));

        return $arr;

    }


    protected function beforeValidate() {

        $this->mtime = date("Y-m-d H:i:s");

        $this->author_id = Yii::app()->user->id;

        return parent::beforeValidate();
    }

}