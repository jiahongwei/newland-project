<?php

/**
 * This is the model class for table "st_student".
 *
 * The followings are the available columns in table 'st_student':
 * @property integer $stuId
 * @property string $stuName
 * @property integer $classId
 * @property string $phone
 * @property string $profession
 * @property integer $grade
 * @property string $lastUpdateTime
 * @property string $feature
 * @property string $photo
 */
class StStudent extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'st_student';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stuId', 'required'),
			array('stuId, classId, grade', 'numerical', 'integerOnly'=>true),
			array('stuName, phone, profession', 'length', 'max'=>255),
			array('lastUpdateTime, feature, photo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('stuId, stuName, classId, phone, profession, grade, lastUpdateTime, feature, photo', 'safe', 'on'=>'search'),
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
			'stuId' => 'Stu',
			'stuName' => 'Stu Name',
			'classId' => 'Class',
			'phone' => 'Phone',
			'profession' => 'Profession',
			'grade' => 'Grade',
			'lastUpdateTime' => 'Last Update Time',
			'feature' => 'Feature',
			'photo' => 'Photo',
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

		$criteria->compare('stuId',$this->stuId);
		$criteria->compare('stuName',$this->stuName,true);
		$criteria->compare('classId',$this->classId);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('grade',$this->grade);
		$criteria->compare('lastUpdateTime',$this->lastUpdateTime,true);
		$criteria->compare('feature',$this->feature,true);
		$criteria->compare('photo',$this->photo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return StStudent the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
