<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;
use DB;

class YDB
{
	static $data=[];
	static $connection='';
	static $query="";
	static $table=null;




	public function __constract($con=null,$data=[],$table=null){

		if(!$con){
			static::$connection=env('DB_CONNECTION','pgsql');
		}else{
			static::$connection=$con;
		}	
		if(!empty($data)){
			static::$data=$data;
		}else{
			static::$data=null;
		}	
		if(!empty($table)){
			static::$table=$table;
		}else{
			static::$table=null;
		}		
	}

	public static function first(){


		if(isset(static::$data)){
			if(strpos(static::$query, 'limit 1')===0){
				static::$query.='limit 1';
				$data= static::$data->select(DB::raw(static::$query));
				if($data){
					if(isset($data[0])){
						return $data[0];
					}else{
						return null;
					}
				}else{
					return null;
				}

			}else{
				$data= static::$data->select(DB::raw(static::$query));
				if($data){
					if(isset($data[0])){
						return $data[0];
					}else{
						return null;
					}
				}else{
					return null;
				}
			}

		}else{
			return null;
		}
	}

	public static function table($name){
		static::$table=DB::connection(static::$connection)->table($name);
		return new self(static::$connection,static::$data,static::$table);		
	}

	public static function insert($array_data){
		return static::$table->insert($array_data);
	}

	public static function delete(){
		return static::$table->delete();
	}

	public static function update($array_data){
		return static::$table->update($array_data);
	}


	public static function query($query){
		static::$query=$query;
		static::$data=DB::connection(static::$connection);
		return new self(static::$connection,static::$data);
	}

	public static function get(){
		if(!empty(static::$data)){
			return static::$data->select(DB::raw(static::$query));
		}else{
			return [];
		}
	}


}