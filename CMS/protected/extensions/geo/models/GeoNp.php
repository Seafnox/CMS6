<?php

/**
 * This is the model class for table "geo_np".
 *
 * The followings are the available columns in table 'geo_np':
 * @property integer $id
 * @property integer $rajon_id
 * @property string $clean_title
 * @property string $title
 * @property string $title2
 * @property string $type
 * @property string $type_ext
 * @property string $code
 *
 * The followings are the available model relations:
 * @property GeoRajon $rajon
 */
class GeoNp extends GeoModel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return GeoNp the static model class
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
		return 'geo_np';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rajon_id, title, title2, type, code', 'required'),
			array('rajon_id', 'numerical', 'integerOnly'=>true),
			array('title, title2, clean_title, type_ext, code', 'length', 'max'=>255),
			array('type', 'length', 'max'=>16),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rajon_id, title, title2, clean_title, type_ext, type, code', 'safe', 'on'=>'search'),
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
			'rajon' => array(self::BELONGS_TO, 'GeoRajon', 'rajon_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rajon_id' => 'Rajon',
			'title' => 'Title',
			'title2' => 'Title2',
			'type' => 'Type',
			'code' => 'Code',
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
		$criteria->compare('rajon_id',$this->rajon_id);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('title2',$this->title2,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}