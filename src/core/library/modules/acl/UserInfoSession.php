<?php
/**
 * 
 * User Session dentro do projeto
 * Informações de um usuario logado
 * 
 * @author renatomiawaki
 *
 */
class UserInfoSession {
	const SESSION_VAR_USER 				    			= "SESSION_VAR_USER" ;
	const SESSION_VAR_USER_NAME							= "SESSION_VAR_USER_NAME";
	const SESSION_VAR_USER_EMAIL							= "SESSION_VAR_USER_EMAIL";
	const SESSION_VAR_LAST_ACCESS 				    	= "SESSION_VAR_LAST_ACCESS" ;
	const SESSION_VAR_USER_ID 				    		= "SESSION_VAR_USER_ID" ;
	const SESSION_VAR_USER_CURRENT_TYPE_ID 				= "SESSION_VAR_USER_CURRENT_TYPE_ID" ;
	public static function setInfo( $value ){
		ARMSession::setVar( self::SESSION_VAR_USER , json_encode($value) );
	}

	/**
	 * @return AccountApiUserInfoVO
	 */
	public static function getInfo(){
		if(!ARMSession::getVar( self::SESSION_VAR_USER )){
			return NULL ;
		}
		return json_decode( ARMSession::getVar( self::SESSION_VAR_USER ) );
	}
	public static function setUserId($id){
		ARMSession::setVar( self::SESSION_VAR_USER_ID , $id );
	}
	public static function setUserName( $value ){
		ARMSession::setVar( self::SESSION_VAR_USER_NAME, $value ) ;
	}
	public static function setUserEmail( $value ){
		ARMSession::setVar( self::SESSION_VAR_USER_EMAIL , $value) ;
	}

	public static function getUserName(){
		return ARMSession::getVar( self::SESSION_VAR_USER_NAME ) ;
	}
	public static function getUserEmail(){
		return ARMSession::getVar( self::SESSION_VAR_USER_EMAIL ) ;
	}

//UserInfoSession::setUserId( $AccountApiUserInfoVO->id ) ;
//UserInfoSession::setUserName( $AccountApiUserInfoVO->name ) ;
//UserInfoSession::setUserEmail( $AccountApiUserInfoVO->email ) ;

	public static function getUserId(){
		return ARMSession::getVar( self::SESSION_VAR_USER_ID ) ;
	}

	/**
	 * Setar caso queira forçar que esse usuário está em uma determinada permissão, ou seja, configurado como determinado tipo
	 * O tipo de usuario e o usuario logado é N pra N, porém apenas uma visão será necessária em alguns casos
	 * @param $type
	 *
	 */
	public static function setUserCurrentTypeId($type){
		ARMSession::setVar( self::SESSION_VAR_USER_CURRENT_TYPE_ID  , $type );
	}

	/**
	 * Retorna o tipo de usuario logado, caso seja determinado
	 * @return NULL|unknown
	 */
	public static function getUserCurrentTypeId(){
		return ARMSession::getVar( self::SESSION_VAR_USER_CURRENT_TYPE_ID ) ;
	}

	/**
	 * Mantem o usuario logado, renovando o tempo da sessão, interna.
	 * talvez, por utilizar o sistem de account, o usuário logado nessa sessão pode não estar logado em outra, e mante-lo alive internamente não implica em renovar a sessão na api de account
	 */
	public static function keepAlive(){
		if(self::isAlive()) {
			ARMSession::setVar(self::SESSION_VAR_LAST_ACCESS, time());
		}
	}

	/**
	 * Retorna true se o usuario tiver logado
	 * @return bool
	 */
	public static function isAlive(){
		return ( self::getUserId() && self::getUserId() > 0 ) ;
	}
	public static function destroy(){
		session_destroy() ;
	}
}