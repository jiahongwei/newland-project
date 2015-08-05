<?php

/**
 * This is the model class for table "boardschedule".
 *
 * The followings are the available columns in table 'boardschedule':
 * @property integer $id
 * @property string $startTime
 * @property integer $duration
 * @property integer $classNum
 * @property string $fileName
 * @property string $fileType
 */
class Boardschedule extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'boardschedule';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('duration, classNum', 'numerical', 'integerOnly'=>true),
			array('fileName', 'length', 'max'=>100),
			array('fileType', 'length', 'max'=>20),
			array('startTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, startTime, duration, classNum, fileName, fileType', 'safe', 'on'=>'search'),
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
			'startTime' => 'Start Time',
			'duration' => 'Duration',
			'classNum' => 'Class Num',
			'fileName' => 'File Name',
			'fileType' => 'File Type',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('startTime',$this->startTime,true);
		$criteria->compare('duration',$this->duration);
		$criteria->compare('classNum',$this->classNum);
		$criteria->compare('fileName',$this->fileName,true);
		$criteria->compare('fileType',$this->fileType,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Boardschedule the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
