<?php

/**
 * This is the model class for table "config".
 *
 * The followings are the available columns in table 'config':
 * @property integer $id
 * @property string $title
 * @property string $key
 * @property string $value
 * @property string $field
 * @property string $data
 * @property integer $sort
 */

class Config extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('key, value', 'required'),
            array('key', 'unique', 'allowEmpty' => false, 'caseSensitive' => false, 'attributeName' => 'key', 'className' => 'Config'),
			array('key', 'length', 'max'=>128),
            array('key', 'match', 'pattern' => '/^([A-z0-9_])+$/'),
            array('field', 'length', 'max'=>32),
            array('title, data', 'length', 'max'=>256),
            array('sort', 'numerical', 'integerOnly' => true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, key, value, field, data, sort', 'safe', 'on'=>'search'),
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
			'key' => Yii::t('app', 'Key'),
			'value' => Yii::t('app', 'Value'),
            'field' => Yii::t('app', 'Field'),
            'data' => Yii::t('app', 'Data'),
            'sort' => Yii::t('app', 'Sort'),
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
        $criteria->compare('title',$this->title,true);
		$criteria->compare('key',$this->key,true);
		$criteria->compare('value',$this->value,true);
        $criteria->compare('field',$this->field,true);
        $criteria->compare('data',$this->data,true);
        $criteria->compare('sort',$this->sort);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    /**
     * Возвращает данные для заполнения
     * @return array
     */

    public function getData() {

        if(!empty($this->data))
            return eval($this->data);
        else return array();

    }

    /**
     * Возвращает все модели. Ключ массива id модели
     * @return array
     */

    public function getAllModels() {


        $arr = array();

        $models = $this->findAll(array("order"=>"sort desc"));

        foreach($models AS $model)
            $arr[$model->id] = $model;

        return $arr;

    }

}