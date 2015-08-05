<?php

/**
 * This is the model class for table "as_apply".
 *
 * The followings are the available columns in table 'as_apply':
 * @property integer $applyId
 * @property integer $stuId
 * @property string $stuName
 * @property string $specification
 * @property string $assetName
 * @property string $applyTime
 * @property string $loanTime
 * @property string $returnTime
 * @property string $RFID
 * @property string $stuTelNum
 */
class AsApply extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'as_apply';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stuId, stuName, assetName, applyTime, loanTime, stuTelNum', 'required'),
			array('stuId', 'numerical', 'integerOnly'=>true),
			array('stuName, specification, assetName, RFID, stuTelNum', 'length', 'max'=>20),
			array('returnTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('applyId, stuId, stuName, specification, assetName, applyTime, loanTime, returnTime, RFID, stuTelNum', 'safe', 'on'=>'search'),
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
			'stuName' => 'Stu Name',
			'specification' => 'Specification',
			'assetName' => 'Asset Name',
			'applyTime' => 'Apply Time',
			'loanTime' => 'Loan Time',
			'returnTime' => 'Return Time',
			'RFID' => 'Rfid',
			'stuTelNum' => 'Stu Tel Num',
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
		$criteria->compare('stuName',$this->stuName,true);
		$criteria->compare('specification',$this->specification,true);
		$criteria->compare('assetName',$this->assetName,true);
		$criteria->compare('applyTime',$this->applyTime,true);
		$criteria->compare('loanTime',$this->loanTime,true);
		$criteria->compare('returnTime',$this->returnTime,true);
		$criteria->compare('RFID',$this->RFID,true);
		$criteria->compare('stuTelNum',$this->stuTelNum,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsApply the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
