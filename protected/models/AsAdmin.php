<?php

/**
 * This is the model class for table "as_admin".
 *
 * The followings are the available columns in table 'as_admin':
 * @property integer $adminId
 * @property string $adminName
 * @property string $password
 * @property string $phone
 * @property integer $storageId
 */
class AsAdmin extends XBaseModel
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'as_admin';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('adminId, adminName, password, phone, storageId', 'required'),
			array('adminId, storageId', 'numerical', 'integerOnly'=>true),
			array('adminName, password, phone', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('adminId, adminName, password, phone, storageId', 'safe', 'on'=>'search'),
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
			'adminId' => 'Admin',
			'adminName' => 'Admin Name',
			'password' => 'Password',
			'phone' => 'Phone',
			'storageId' => 'Storage',
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

		$criteria->compare('adminId',$this->adminId);
		$criteria->compare('adminName',$this->adminName,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('storageId',$this->storageId);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AsAdmin the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function validatePassword ($password)
	{
		return $this->password === $password;
	}
}
