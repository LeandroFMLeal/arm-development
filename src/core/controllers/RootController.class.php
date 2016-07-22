<?php

/**
 * @author 	Renato Miawaki
 * @desc	Controller central, se nenhuma outra controller for encontrada, esta controller é iniciada
 * 			init é chamada caso nenhum metodo que combine com a requisição seja encontrada
 */

class RootController implements ARMApplicationInitInterface {

	public function __construct(){
	}
	public function init(){
		return NULL ;
	}
	public static function applicationInit(){
		ARMSession::start() ;

		date_default_timezone_set('America/Sao_Paulo');
		//TODO: precisa determinar o tipo de visão para cada tipo de projeto dentro do padrão do portal
		//A url define a visão e o ACL cuida pra ver se a pessoa logada tem ou não a premissão necessária para acessar o conteúdo
//		ARMSimplePHPResult::setDefaultAlias("portal");
//		ARMSimpleFileModule::getInstance();
//		ImageManagerModule::getInstance();
//		ARMNavigation::getAppUrl();
		//d( UserInfoSession::getInfo()->name ) ;
	}
}
