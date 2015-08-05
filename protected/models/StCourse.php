<?php

/**
 * This is the model class for table "st_course".
 *
 * The followings are the available columns in table 'st_course':
 * @property integer $courseId
 * @property string $courseName
 * @property integer $teacherId
 * @property integer $total
 */
class StCourse extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'st_course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('courseId', 'required'),
			array('courseId, teacherId, total', 'numerical', 'integerOnly'=>true),
			array('courseName', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('courseId, courseName, teacherId, total', 'safe', 'on'=>'search'),
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
			'courseId' => 'Course',
			'courseName' => 'Course Name',
			'teacherId' => 'Teacher',
			'total' => 'Total',
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

		$criteria->compare('courseId',$this->courseId);
		$criteria->compare('courseName',$this->courseName,true);
		$criteria->compare('teacherId',$this->teacherId);
		$criteria->compare('total',$this->total);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StCourse the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
