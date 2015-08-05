<?php

/**
 * This is the model class for table "as_asset".
 *
 * The followings are the available columns in table 'as_asset':
 * @property string $RFID
 * @property string $assetName
 * @property string $specification
 * @property double $Price
 * @property integer $storageId
 * @property string $inTime
 * @property string $outPrm
 * @property string $state
 * @property string $scrapeTime
 * @property string $brwPhone
 */
class AsAsset extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'as_asset';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('RFID, assetName, specification, Price, storageId, inTime, outPrm, state', 'required'),
			array('storageId', 'numerical', 'integerOnly'=>true),
			array('Price', 'numerical'),
			array('RFID, brwPhone', 'length', 'max'=>255),
			array('assetName, specification, outPrm, state', 'length', 'max'=>20),
			array('scrapeTime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('RFID, assetName, specification, Price, storageId, inTime, outPrm, state, scrapeTime, brwPhone', 'safe', 'on'=>'search'),
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
			'RFID' => 'Rfid',
			'assetName' => 'Asset Name',
			'specification' => 'Specification',
			'Price' => 'Price',
			'storageId' => 'Storage',
			'inTime' => 'In Time',
			'outPrm' => 'Out Prm',
			'state' => 'State',
			'scrapeTime' => 'Scrape Time',
			'brwPhone' => 'Brw Phone',
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

		$criteria->compare('RFID',$this->RFID,true);
		$criteria->compare('assetName',$this->assetName,true);
		$criteria->compare('specification',$this->specification,true);
		$criteria->compare('Price',$this->Price);
		$criteria->compare('storageId',$this->storageId);
		$criteria->compare('inTime',$this->inTime,true);
		$criteria->compare('outPrm',$this->outPrm,true);
		$criteria->compare('state',$this->state,true);
		$criteria->compare('scrapeTime',$this->scrapeTime,true);
		$criteria->compare('brwPhone',$this->brwPhone,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsAsset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
