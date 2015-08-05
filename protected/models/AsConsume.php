<?php

/**
 * This is the model class for table "as_consume".
 *
 * The followings are the available columns in table 'as_consume':
 * @property string $assetId
 * @property string $assetName
 * @property string $specification
 * @property string $state
 * @property integer $storageId
 * @property string $inTime
 * @property string $outPrm
 * @property string $brwPhone
 * @property double $Price
 */
class AsConsume extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'as_consume';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('assetId, assetName, specification, state, storageId, inTime, outPrm, Price', 'required'),
			array('storageId', 'numerical', 'integerOnly'=>true),
			array('Price', 'numerical'),
			array('assetId', 'length', 'max'=>11),
			array('assetName, specification, state, outPrm, brwPhone', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('assetId, assetName, specification, state, storageId, inTime, outPrm, brwPhone, Price', 'safe', 'on'=>'search'),
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
			'assetId' => 'Asset',
			'assetName' => 'Asset Name',
			'specification' => 'Specification',
			'state' => 'State',
			'storageId' => 'Storage',
			'inTime' => 'In Time',
			'outPrm' => 'Out Prm',
			'brwPhone' => 'Brw Phone',
			'Price' => 'Price',
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

		$criteria->compare('assetId',$this->assetId,true);
		$criteria->compare('assetName',$this->assetName,true);
		$criteria->compare('specification',$this->specification,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('storageId',$this->storageId);
		$criteria->compare('inTime',$this->inTime,true);
		$criteria->compare('outPrm',$this->outPrm,true);
		$criteria->compare('brwPhone',$this->brwPhone,true);
		$criteria->compare('Price',$this->Price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsConsume the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
