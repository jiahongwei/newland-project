<?php

/**
 * This is the model class for table "st_apply".
 *
 * The followings are the available columns in table 'st_apply':
 * @property integer $applyId
 * @property integer $stuId
 * @property integer $classTimeId
 * @property string $reason
 * @property integer $state
 */
class StApply extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'st_apply';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stuId, classTimeId', 'required'),
			array('stuId, classTimeId, state', 'numerical', 'integerOnly'=>true),
			array('reason', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('applyId, stuId, classTimeId, reason, state', 'safe', 'on'=>'search'),
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
			'applyId' => 'Apply',
			'stuId' => 'Stu',
			'classTimeId' => 'Class Time',
			'reason' => 'Reason',
			'state' => 'State',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('applyId',$this->applyId);
		$criteria->compare('stuId',$this->stuId);
		$criteria->compare('classTimeId',$this->classTimeId);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('state',$this->state);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StApply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
