<?php

/**
 * Nesse controle simples  de acesso, irá controlar sómente a questão de acesso as controllers pelo tipo de usuario
 * 
 * 
 * 
 * @author renatomiawaki
 *
 */
class BasicAccessControll implements ARMRequestAccessControllInterface{
	
	/* (non-PHPdoc)
	 * @see ARMRequestAccessControllInterface::hasAccess()
	 */
	public function hasAccess( $className, $methodName, $requestType ) {
		return true;
	}
	
	/**
	 * @return ARMHttpRequestDataVO
	 */
	public function requestAccessResult() {
		// Lembrar que se a view nao estiver preparada pro erro diferente de 200, causará erros graves
		$ARMHttpRequestDataVO = new ARMHttpRequestDataVO() ;
		$ARMHttpRequestDataVO->code = 200 ;

		return $ARMHttpRequestDataVO ;
	}

}