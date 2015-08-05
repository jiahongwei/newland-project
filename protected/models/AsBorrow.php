<?php

/**
 * This is the model class for table "as_borrow".
 *
 * The followings are the available columns in table 'as_borrow':
 * @property integer $borrowId
 * @property integer $userId
 * @property string $userName
 * @property string $userTeleNum
 * @property string $assetID
 * @property string $assetName
 * @property string $type
 * @property string $assetSpecification
 * @property string $borrowTime
 * @property string $returnTime
 */
class AsBorrow extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'as_borrow';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userId, userName, userTeleNum, assetID, assetName, type, assetSpecification, borrowTime', 'required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('userName, userTeleNum, assetID, assetName, type, assetSpecification', 'length', 'max'=>255),
			array('returnTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('borrowId, userId, userName, userTeleNum, assetID, assetName, type, assetSpecification, borrowTime, returnTime', 'safe', 'on'=>'search'),
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
			'borrowId' => 'Borrow',
			'userId' => 'User',
			'userName' => 'User Name',
			'userTeleNum' => 'User Tele Num',
			'assetID' => 'Asset',
			'assetName' => 'Asset Name',
			'type' => 'Type',
			'assetSpecification' => 'Asset Specification',
			'borrowTime' => 'Borrow Time',
			'returnTime' => 'Return Time',
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

		$criteria->compare('borrowId',$this->borrowId);
		$criteria->compare('userId',$this->userId);
		$criteria->compare('userName',$this->userName,true);
		$criteria->compare('userTeleNum',$this->userTeleNum,true);
		$criteria->compare('assetID',$this->assetID,true);
		$criteria->compare('assetName',$this->assetName,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('assetSpecification',$this->assetSpecification,true);
		$criteria->compare('borrowTime',$this->borrowTime,true);
		$criteria->compare('returnTime',$this->returnTime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsBorrow the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
