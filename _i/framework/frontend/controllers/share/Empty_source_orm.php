<?php
// 不要覺得奇怪，這個檔案有兩個controller會讀這支檔案去eval，請不要任意改動本行的上一行和下一行，由其是多了跳行這件事！
class Empty_source_orm extends CActiveRecord
{
	protected static $_tableName;
	protected static $_rules = array();
	protected static $_primary_key;

	// gisanfu hack
	//public static $_models=array();			// class name => model

	public $_orm_data = array();

	public static $_static_orm_data = array();

	/*
	 * array(10) {
	 *   ["is_enable"]=>
	 *   int(1)
	 *   ["sell_card_number"]=>
	 *   string(16) "6220430900000041"
	 *   ["buy_card_number"]=>
	 *   string(16) "6220430900000040"
	 *   ["comments"]=>
	 *   string(0) ""
	 *   ["d"]=>
	 *   string(788) "{"sell_card_number":"6220430900000041","sell_transation_cash_a":"0","sell_transation_cash_b":"100","sell_transation_eob_a":"0","sell_transation_eob_b":"20","sell_administrative_eob_a":"0","sell_administrative_eob_b":"0","sell_administrative_cash_a":"0","sell_administrative_cash_b":"0","transation_eob":"0","transation_cash":"1000","buy_sign_marking_eob":"0","buy_sign_marking_cash":"0","buy_sign_admin_eob":"0","buy_sign_admin_cash":"0","buy_sign_debtres_eob":"0","buy_sign_debtres_cash":"0","buy_card_number":"6220430900000040","buy_transation_cash_a":"0","buy_transation_cash_b":"0","buy_transation_eob_a":"0","buy_transation_eob_b":"0","buy_administrative_eob_a":"0","buy_administrative_eob_b":"0","buy_administrative_cash_a":"0","buy_administrative_cash_b":"0","transation_type":"1"}"
	 *   ["create_time"]=>
	 *   object(CDbExpression)#25 (4) {
	 *     ["expression"]=>
	 *     string(5) "NOW()"
	 *     ["params"]=>
	 *     array(0) {
	 *     }
	 *     ["_e":"CComponent":private]=>
	 *     NULL
	 *     ["_m":"CComponent":private]=>
	 *     NULL
	 *   }
	 *   ["from_user_id"]=>
	 *   string(1) "1"
	 *   ["id"]=>
	 *   NULL
	 *   ["checkout_time"]=>
	 *   NULL
	 *   ["update_time"]=>
	 *   NULL
	 * }
	 */
	// 可不要跟addColumn混在一起，或混為一談
	public function autoaddcolumn($fields = array())
	{
		if(count($fields) > 0 and isset(self::$_tableName)){
			$tmp = Yii::app()->db->schema->getTable(self::$_tableName)->columns;
			$tmp2 = array();
			// 只取key出來
			foreach($tmp as $k => $v){
				$tmp2[] = $k;
			}

			foreach($fields as $k => $v){
				/*
				 * http://stackoverflow.com/questions/12506062/addcolumn-yii-migration-position
				 */

				// 為transation資料表而設計的
				//if(preg_match('/^(sell_|buy_|transation_|eob_)/', $k) and !in_array($k, $tmp2)){

				// 為懶而設計的
				//if(!in_array($k, $tmp2)){
				//	$sql = Yii::app()->db->schema->addColumn(self::$_tableName, $k, 'VARCHAR(50) AFTER `id`');
				//	Yii::app()->db->createCommand($sql)->execute();
				//}
			}
		}
	}

	// 當new完這個東西後，別忘了unset那個新變數
	public function __destruct()
	{
		//echo 'XXX';
		//echo __CLASS__;
		$this->_orm_data = array();

		self::$_tableName = '';
		self::$_rules = array();
		self::$_primary_key = '';

		self::$_static_orm_data = array();

		// test xxx
		//self::$_models = array();
		//var_dump(self::$_models);
		//die;

		//self::$db=null;

		// CModel #244
		//$this->_validators = null;
	}

	/**
	 * Returns the meta-data for this AR
	 * @return CActiveRecordMetaData the meta for this AR class.
	 */
	//public function getMetaData()
	//{
	//	//if($this->_md!==null)
	//	//	return $this->_md;
	//	//else
	//		return $this->_md=self::model(get_class($this))->_md;
	//}

	public function __construct($scenario = 'insert', $orm_data = array())
	{
		//if($scenario == 'xx'){
		//	//var_dump($this->_md);
		//	//$this->_md = null;
		//	//var_dump($this->rules());
		//	//var_dump($this->_validators);
		//	//var_dump($this->attributeLabels());
		//	var_dump($this->_attributes);
		//	die;
		//}

		//if($scenario == 'insertg'){
		//	var_dump($orm_data);
		//	die;
		//}

		//$this->_orm_data = array();
		//self::$_rules = array();
		//self::$_static_orm_data = array();

		//self::clear_object();
		//echo 's';
		//$this->refreshMetaData();
		//$this->getMetaData();
		//die;
		// debug
		//if(isset($orm_data['table'])){
		//	file_put_contents('/home/gisanfu/aaa.txt', $orm_data['table']."\n", FILE_APPEND);
		//} else {
		//	file_put_contents('/home/gisanfu/aaa.txt', 'nodata'."\n", FILE_APPEND);
		//}

		if(count($orm_data) <= 0 and count($this->_orm_data) > 0){
			$orm_data = $this->_orm_data;
		//} else {
		//	// http://stackoverflow.com/questions/5812953/how-do-you-clear-a-static-variable-in-php-after-recursion-is-finished
		//	$this->_orm_data = array();

		//	self::$_tableName = '';
		//	self::$_rules = array();
		//	self::$_primary_key = '';

		//	self::$_static_orm_data = array();
		}
		//var_dump($orm_data);

		self::$_static_orm_data = $orm_data;

		//if($scenario == 'insertg'){
		//	var_dump($orm_data);
		//	//die;
		//}

		//var_dump($orm_data);

		if(isset($orm_data['table']) and $orm_data['table'] != ''){
			//echo $orm_data['table'];
			//echo '123';
			//die;
			self::$_tableName = $orm_data['table'];
		}
		//file_put_contents('/home/gisanfu/aaa.txt', '[tablename] '.self::$_tableName."\n", FILE_APPEND);
		//if($orm_data['table'] == 'ml_lang'){
		//	die;
		//}
		//var_dump($this->_attributes);
		//die;
		//$a=$this->_attributes;
		//var_dump($this->getAttributes(array('order')));
		//echo '123';
		//die;

		// 存放己定義的欄位，未定義的部份才是我的目標，我要把它們補齊
		$defined_fields = array();
		$defined_fields_tmp = array();

		// 將Rules帶進來

		// XXX
		//self::$_rules = array(); // 這裡是測試用，還不確定是否能夠繼承以及修正問題 2013/7/9

		//var_dump($orm_data);
		if(isset($orm_data['rules']) and count($orm_data['rules']) > 0){
			self::$_rules = $orm_data['rules'];

			// 記錄己定義的欄位
			foreach($orm_data['rules'] as $v){
				//if(preg_match('/\,/', $v)){
				//}
				$fields_tmp = $v[0];
				$fields = array();
				if(preg_match('/\,/', $fields_tmp)){
					$tmps = explode(',', $fields_tmp);
					foreach($tmps as $kk => $vv){
						$defined_fields_tmp[trim($vv)] = '1';
					}
				} else {
					$defined_fields_tmp[trim($fields_tmp)] = '1';
				}
			}
		//} else {
		//	self::$_rules = array();
		}

		/*
		 * 將新增時間，和更新時間的預設值補上去，如果該controller要使用的話，這兩個section就會啟用
		 */

		$have_update = false;
		if(isset($orm_data['updated_field']) and $orm_data['updated_field'] != ''){
			$defined_fields_tmp[$orm_data['updated_field']] = '1';
			$have_update = true;
			self::$_rules[] = array(
				$orm_data['updated_field'], 'default',
				'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false,
				'on'=>'update',
			);
		}

		if(isset($orm_data['created_field']) and $orm_data['created_field'] != ''){
			$defined_fields_tmp[$orm_data['created_field']] = '1';
			$tmp = $orm_data['created_field'];
			if($have_update){
				$tmp .= ', '.$orm_data['updated_field'];
			}
			self::$_rules[] = array(
				$tmp, 'default',
				'value'=>new CDbExpression('NOW()'),
				'setOnEmpty'=>false,
				'on'=>'insert',
			);
		}

		if(isset($orm_data['primary']) and $orm_data['primary'] != ''){
			$defined_fields_tmp[$orm_data['primary']] = '1';
			self::$_primary_key = $orm_data['primary'];
		}

		// 整理一下己定義的欄位
		if(count($defined_fields_tmp) > 0){
			foreach($defined_fields_tmp as $k => $v){
				$defined_fields[] = $k;
			}
		}

		/*
			string(2) "id"
			object(CMysqlColumnSchema)#23 (14) {
			  ["name"]=>
			  string(2) "id"
			  ["rawName"]=>
			  string(4) "`id`"
			  ["allowNull"]=>
			  bool(false)
			  ["dbType"]=>
			  string(7) "int(11)" 這裡有的變化，大約有int(11), varchar(50), tinyint(1), text, datetime...
			  ["type"]=>
			  string(7) "integer" 還有string，我在猜，應該是要不要加上雙引數吧，在儲存的時候
			  ["defaultValue"]=>
			  NULL
			  ["size"]=>
			  int(11)
			  ["precision"]=>
			  int(11)
			  ["scale"]=>
			  NULL
			  ["isPrimaryKey"]=>
			  bool(true)
			  ["isForeignKey"]=>
			  bool(false)
			  ["autoIncrement"]=>
			  bool(true)
			  ["_e":"CComponent":private]=>
			  NULL
			  ["_m":"CComponent":private]=>
			  NULL
			}

				array('login_account, email', 'required'),
				array('email', 'email'),
				array('is_enable, is_hidden', 'length', 'max'=>1),
				array('is_enable', 'default', 'value' => '1'),
				array('create_time, update_time', 'default',
					'value'=>new CDbExpression('NOW()'),
					'setOnEmpty'=>false,
					'on'=>'insert',
				),
		*/
		// @k string 欄位名稱，我打算用$v[name]，比較保險
		//foreach(Yii::app()->db->schema->getTable(self::$_tableName)->columns as $v) {
		if(isset($orm_data['table'])){

			// 針對實體資料表頁面的欄位一個一個來處理
			foreach(Yii::app()->db->schema->getTable($orm_data['table'])->columns as $v) {
				// 如果上面有define過，就跳過吧，相信define的那個人
				if(in_array($v->name, $defined_fields)){
					continue;
				}

				// 如果from_user_id有存在，那就自動帶登入者的編號當預設值
				if($v->name == 'from_user_id' and isset(Yii::app()->session['auth_admin_id']) and Yii::app()->session['auth_admin_id'] != ''){
					self::$_rules[] = array(
						$v->name, 'default', 'value'=> Yii::app()->session['auth_admin_id'],
					);
				}

				// 符合某些條件，會自動建欄位

				// 不要理我，因為我看錯了
				//if($v->dbType == 'text'){
				//	self::$_rules[] = array(
				//		$v->name, 'ext.myvalidators.ignoreall'
				//	);
				//	continue;
				//}

				// 依特專用
				//if($v->dbType == 'text'){
				//	self::$_rules[] = array(
				//		$v->name, 'ext.myvalidators.emtechnikckeditor'
				//	);
				//	continue;
				//}

				if($v->defaultValue != ''){
					// 為了要看最後要不要加一個通用的
					$defined_fields_tmp[$v->name] = '1';

					self::$_rules[] = array(
						$v->name, 'default', 'value'=>$v->defaultValue,
					);
				}

				if($v->size !== null){
					// 為了要看最後要不要加一個通用的
					$defined_fields_tmp[$v->name] = '1';

					self::$_rules[] = array(
						$v->name, 'length', 'max'=>$v->size,
					);
				}

				// 最後一招，沒步了，送一個沒有做任何事情的空的自訂validator
				// 只有做了幾次的測試，看起來好像沒有什麼問題
				if(!isset($defined_fields_tmp[$v->name])){
					self::$_rules[] = array(
						//$v->name, 'ext.myvalidators.ignoreall',
						$v->name, 'system.backend.extensions.myvalidators.ignoreall',
					);
				}

				//var_dump($v);
			}
		}
		//var_dump($scenario);
		//echo 'x';
		//echo '<br />';

		// debug
		//var_dump(self::$_rules);
		//die;

		//if($scenario == 'insertg'){
		//	var_dump(self::$_rules);
		//	die;
		//}

		parent::__construct($scenario);

		//if(self::$_tableName == 'ml_lang'){
		//	echo '123';
		//	die;
		//}
	}

	/*
	 * 這是由CActiveRecord複製過來的，有幾行mark起來而以
	 */
	public static function model($className=__CLASS__)
	{
		//if(isset(self::$_models[$className]))
		//	return self::$_models[$className];
		//else
		//{
			$model=self::$_models[$className]=new $className(null);
			$model->_md=new CActiveRecordMetaData($model);
			$model->attachBehaviors($model->behaviors());
			return $model;
		//}
	}

	public function getOrmRule(){ if(isset($this->_orm_data["rules"])){ return $this->_orm_data["rules"]; } else { return array(); }}
	public function getOrmData(){ if(count($this->_orm_data) > 0){ return $this->_orm_data; } else { return array(); }}

    //public static function model($className=__CLASS__)
    //{
    //    return parent::model($className);
    //}

	//public static function table_name()
	//{
	//	return self::$_tableName;
	//}
 
	// 
	public function tableName()
	{
		//file_put_contents('/home/gisanfu/aaa.txt', 'return table=>'.self::$_tableName."\n", FILE_APPEND);
		return self::$_tableName;

		// http://www.larryullman.com/forums/index.php?/topic/1975-using-model-with-dynamic-table-name/page-1
		//return '{{'.self::$_tableName.'}}';
	}

	//public function setTableName($tableName)
	//{
	//	self::$_tableName = $tableName;
	//}

	public function rules()
	{
		//var_dump(self::$_rules);
		//die;
		return self::$_rules;
	}

	public function primaryKey()
	{
		return self::$_primary_key;
	}
}
