<?php
//設定
class Config{
	
	//const PATH_DRIVE = 'E:/MUS/';
	//const PATH_DRIVE = 'G:/MUS/';
	const PATH_DRIVE = '';
	const PATH_ROOT = '/home/demo/batch/news/';
	//const PATH_ROOT = 'G:/MUS/home/demo/batch/news/';
	const PATH_CORE = 'v2';
	const PATH_WORK = 'work';
	const PATH_LOG = 'logs';
	const PATH_EXEC = 'exec';
	const PATH_TEMP = 'temp';
	const PATH_LOCK = 'lock';
	const PATH_MOVIE = 'movie';
	const PATH_PLAY = 'playlist';
	
	const FILE_LOG = 'batch.log';
	
	const MODE_TEST = true;
	
	// const DB_DSN = 'pgsql:dbname=demo;host=192.168.0.20';
	//const DB_DSN = 'pgsql:dbname=demo;host=10.50.87.14';
	//const DB_DSN = 'pgsql:dbname=demo;host=10.50.87.15';
	const DB_DSN = 'pgsql:dbname=demo;host=db';
	const DB_USER = 'demo';
	const DB_PASSWORD = 'y8hvZ3jF6ibE';
	
	//トップクリエーション
	const ADMIN_UNIT = 1;
	
	public static function get_mode($mode_test){
		if(is_null($mode_test)){
			$mode_test = self::MODE_TEST;
		}
		return $mode_test;
	}
	
	public static function get_db() {
		
		$dsn = self::DB_DSN;
		$user = self::DB_USER;
		$password = self::DB_PASSWORD;

		try {
			//接続
			$pdo = new PDO($dsn, $user, $password);
			$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
			return $pdo;
			
		} catch (PDOException $e) {
			var_dump($e->getMessage());
		}
	}
	public static function exec_db($stmt,$params,$option='')
	{
		foreach ($params as $key=>$param) {
			$btype = PDO::PARAM_STR;
			if(is_int($param)) {
				$btype = PDO::PARAM_INT;
			} else if (is_bool($param)) {
				$btype = PDO::PARAM_BOOL;
			} else if (is_null($param)) {
				$btype = PDO::PARAM_NULL;
			}
			$bresult = $stmt->bindValue($option.$key, $param, $btype);
			if (!$bresult) {
				$errinfo = $stmt->errorInfo();
				throw new Exception($errinfo[2], $errinfo[1]);
			}
		}
		$result = $stmt->execute();
		if (!$result) {
			$errinfo = $stmt->errorInfo();
			throw new Exception($errinfo[2], $errinfo[1]);
		}
		return $result;
	}
	public static function str_db($params,$mode=0,$option='')
	{
		$delimiter=",";
		$result = '';
		foreach($params as $key=>$param)
		{
			if(!empty($result)) $result .= $delimiter;
			$result .= ($mode == 0) ? $option.$key : $key."=".$option.$key;
		}
		return $result;
	}
	public static function get_root($mode_test = null){
		$mode_test = self::get_mode($mode_test);
		
		$return = self::PATH_ROOT;
		if($mode_test){
			$return = self::PATH_DRIVE . $return;
		}
		return $return;
	}
	public static function get_path($path = null, $mode_test = null) {
		$mode_test = self::get_mode($mode_test);
		
		$return = self::get_root($mode_test);
		
		if(!is_null($path) and !is_array($path)){
			$path = array($path);
		}
		
		if(is_array($path)){
			foreach($path as $value){
				$return .= $value . '/';
			}
		}
		
		if($mode_test){
			$return = str_replace('/',DIRECTORY_SEPARATOR,$return);
		}
		
		return $return;
	}
	public static function get_list($id=null,$mode_test = null) {
		//
		$mode_test = self::get_mode($mode_test);
		
		//実行リスト
		//id category_id
		//name classname
		//enable 0 or 1
		//test 0 or 1
		$return = array(
			'4' => array(
				'name' => 'youtube',
				'enable' => 0,
				'test' => (($mode_test) ? 1 : 1),
			),
			'1' => array(
				'name' => 'web',
				'enable' => 0,
				'test' => (($mode_test) ? 1 : 1),
			),
			'2' => array(
				'name' => 'dbc',
				'enable' => 0,
				'test' => (($mode_test) ? 1 : 1),
			),
			'3' => array(
				'name' => 'yahoo',
				'enable' => 1,
				'test' => (($mode_test) ? 1 : 1),
			),
			'5' => array(
				'name' => 'fnn',
				'enable' => 1,
				'test' => (($mode_test) ? 1 : 1),
			),
			'11' => array(
				'name' => 'rss',
				'enable' => 0,
				'test' => (($mode_test) ? 1 : 1),
			),
		);
		if(!is_null($id))
		{
			if(array_key_exists($id,$return))
			{
				return $return[$id];
			}
			else
			{
				return null;
			}
		}
		
		return $return;
	}
	
}
?>