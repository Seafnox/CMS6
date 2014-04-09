<?php

/**
 * This is the model class for table "permission".
 *
 * The followings are the available columns in table 'permission':
 * @property integer $id
 * @property string $role
 * @property string $model
 * @property integer $create
 * @property integer $read
 * @property integer $update
 * @property integer $delete
 * @property string $constraint
 */
class Permission extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Permission the static model class
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
		return 'permission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('role, model', 'required'),
			array('create, read, update, delete', 'numerical', 'integerOnly'=>true),
            array('model', 'uniqueModel'),
			array('role, model', 'length', 'max'=>32),
			array('constraint', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, role, model, create, read, update, delete, constraint', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Валидатор имени модели
     * @param string $attribute
     * @param array $params
     */
    public function uniqueModel($attribute, $params = array())
    {

        $id = !empty($this->id) ? $this->id : 0;


        $params['allowEmpty'] = false;
        $params['caseSensitive'] = false;
        $params['attributeName'] = $attribute;
        $params['className'] = get_class($this);
        $params['criteria'] = array(
                'condition' => 'role=:role AND id != :id',
                'params' => array(':role' => $this->role, ':id' => $id),
            );

        $validator = CValidator::createValidator('unique', $this, $attribute, $params);
        $validator->validate($this, array($attribute));
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
			'role' => Yii::t('app', 'Role'),
			'model' => Yii::t('app', 'Model'),
			'create' => Yii::t('app', 'Create'),
			'read' => Yii::t('app', 'Read'),
			'update' => Yii::t('app', 'Update'),
			'delete' => Yii::t('app', 'Delete'),
			'constraint' => Yii::t('app', 'Constraint'),
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
		$criteria->compare('role',$this->role,true);
		$criteria->compare('model',$this->model,true);
		$criteria->compare('create',$this->create);
		$criteria->compare('read',$this->read);
		$criteria->compare('update',$this->update);
		$criteria->compare('delete',$this->delete);
		$criteria->compare('constraint',$this->constraint,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
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

    /**
     * Создание
     * @return bool
     */

    public function createModel() {

        return $this->create?true:false;

    }


    /**
     * Просмотр списка моделей
     * @param $model CActiveRecord
     * @return bool
     */

    public function listModels() {

        if(empty($this->read))
            return false;

        return true;


    }



    /**
     * Чтение
     * @param $model CActiveRecord
     * @return bool
     */

    public function readModel($model) {

        if(empty($this->read))
            return false;

        $arr = $this->getConstraintArr();

        return $this->testModel($model, $arr);


    }

    /**
     * Обновление
     * @param $model CActiveRecord
     * @return bool
     */

    public function updateModel($model) {

        if(empty($this->update))
            return false;

        $arr = $this->getConstraintArr();

        return $this->testModel($model, $arr);


    }


    /**
     * Удаление
     * @param $model CActiveRecord
     * @return bool
     */

    public function deleteModel($model) {

        if(empty($this->delete))
            return false;

        $arr = $this->getConstraintArr();

        return $this->testModel($model, $arr);


    }

    /**
     * Применяет ограничение к критерию запроса
     * @param $model CActiveRecord
     */

    public function applyConstraint($model) {


        $arr = $this->getConstraintArr();

        if(!empty($arr)) {

            $criteria = $this->constraintToCriteria($arr);

            $modelCriteria = $model->getDbCriteria();

            $modelCriteria->mergeWith($criteria);

        }

    }


    /**
     * Возвращает массив с ограничениями
     * @return array
     */

    protected function getConstraintArr() {

        $arr = array();

        if(!empty($this->constraint)) {

            $arr = eval($this->constraint);

        }

        return $arr;

    }

    /**
     * Проверяет модель на соответствие заданным ограничениям
     * @param $model CActiveRecord модель
     * @param $arr array массив с ограничениями
     * @return bool
     */

    protected function testModel($model, $arr) {

        if(empty($arr))
            return true;

        foreach($arr AS $item) {

            $count = count($item);

            $i = 0;

            foreach($item AS $k=>$v) {

                $attr = end(explode(".", $k));

                if($model->$attr == $v)
                    $i++;

            }

            if($count == $i)
                return true;


        }

        return false;

    }

    /**
     * Преобразует массив с ограничениями в объект CDbCriteria
     * @param $arr массив с ограничениями
     * @return CDbCriteria
     */

    protected function constraintToCriteria($arr) {

        $params = array();

        $condition = null;

        $i = 0;

        foreach($arr AS $item) {

            if($i > 0)
                $condition .= " OR ";

            if(!empty($item)) {

                $condition .= "(";

                $j = 0;

                foreach($item AS $k =>$v) {

                    if($j > 0)
                        $condition .= " AND ";

                    $pk = ":y$i$j";

                    $condition .= "$k = $pk";

                    $params[$pk] = $v;

                    $j++;

                }


                $condition .= ")";

            }


            $i++;

        }

        $criteria = new CDbCriteria();

        $criteria->condition = $condition;

        $criteria->params = $params;

        return $criteria;

    }



}