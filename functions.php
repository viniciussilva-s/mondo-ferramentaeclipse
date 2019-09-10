<?php
use \vCode\Model\User;
use \vCode\Model\Information;
use \vCode\Model\Prev_registers;
use \vCode\Model\ConfigureMenu;
use \vCode\Model\Seconds;
use \vCode\Model\Links;
use \vCode\Model\Way;

function getUserName()
{
	$user = User::getFromSession();
	return $user->getdesname();
}
function verify_OnlyAdmin()
{
	$user = User::getFromSession();
	if(!empty($user->getid_user_role())){
		if($user->getid_user_role() == 1 ){
			return true; 
		}else{
			return false;
		}

	}  
}

// function getUserImage()
// {
// 	$user = User::getFromSession();
// 	if(empty($user->getimage())){
// 		$user->setimage('default.png');
// 	} 
// 	return "http://localhost/desv/desenUserLogin/imagens/".$user->getimage();
// }
// function formatUsersImages($nameImage = ""){
//  	$image = isset($nameImage)?$nameImage:"default.png";			
//  	 return "<img class='imgUser img-circle' src='http://localhost/desv/desenUserLogin/imagens/$image'>";
// }
function getInformation()
{	
	$config=[];
	if (	!isset($_SESSION[Information::ERROR_GENERAL])
 			&& 
 			!isset($_SESSION[Information::SUCCESS_GENERAL])
 	   )
 	{
 		return false; 
 	}
	
 	if(isset($_SESSION[Information::ERROR_GENERAL]) && $_SESSION[Information::ERROR_GENERAL]  ){
 		$error['method']= 'danger';		
 		$error['header']= 'Error !';
 		$error['text'] =  Information::getError_general();
 		array_push($config , $error);
 	}
 	if(isset($_SESSION[Information::SUCCESS_GENERAL]) && $_SESSION[Information::SUCCESS_GENERAL]  ){
 		$success['method']= 'success';		
 		$success['header']= 'Sucesso !';		
 		$success['text'] =  Information::getSuccess_general();
 		array_push($config , $success);

 	}
 	
 			
 	$data = '';
	foreach ($config as $key => $value) {
		$data .= "<div class='alert alert-".$value['method']." alert-dismissible fade show' role='alert'>
		<h6 class='alert-heading'>".$value['text']."</h6>

		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button>
		</div> " ;	
	}
 	 return $data ;
}

function getInformation_record()
{	
	$config=[];
	if (	!isset($_SESSION[Information::ERROR_RECORD])
 			&& 
 			!isset($_SESSION[Information::SUCCESS_RECORD])
 	   )
 	{
 		return false; 
 	}
	
 	if(isset($_SESSION[Information::ERROR_RECORD]) && $_SESSION[Information::ERROR_RECORD]  ){
 		$error['method']= 'danger';		
 		$error['header']= 'Error !';
 		$error['text'] =  Information::getError_record();
 		array_push($config , $error);
 	}
 	if(isset($_SESSION[Information::SUCCESS_RECORD]) && $_SESSION[Information::SUCCESS_RECORD]  ){
 		$success['method']= 'success';		
 		$success['header']= 'Sucesso !';		
 		$success['text'] =  Information::getSuccess_record();
 		array_push($config , $success);

 	}
 	
 			
 	$data = '';
	foreach ($config as $key => $value) {
		$data .= "<div class='alert alert-".$value['method']." alert-dismissible fade show' role='alert'>
		<h6 class='alert-heading'>".$value['text']."</h6>

		<button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
		</button>
		</div> " ;	
	}
 	 return $data ;
 	 die;	
}

function getMenuAlternatives()
{
	$prev_registers = new Prev_registers();

	return $prev_registers->getMenuAlternatives();
}
function getMenuAlternativesDisabled($way)
{
	$prev_registers = new Prev_registers();

	return $prev_registers->getMenuAlternativesDisabled($way);
}
function getMenuAlternativesDisabledLinks($way)
{
	$prev_registers = new Prev_registers();

	return $prev_registers->getMenuAlternativesDisabled($way);
}
function getMenuAlternativasAlterarPageSec($secpagesData )
{
	return Seconds::getMenuAlternativasAlterarPageSec($secpagesData);

}
function getMenuAlternativesAlterLink($linkdata)
{
 return Links::getMenuAlternativesAlterLink($linkdata); 
}
function getMenuAlternativesWay($wayData)
{
 return Way::getMenuAlternativesWay($wayData); 
}

function getHeaderMenuOption()
{

	$data = ConfigureMenu::listAllOptions();
	 return $data['0']; 
}



function quebraLinha($value='')
{
	if(	$data = explode(" ", $value)){
		if(isset($data[1]) ){
			return $data[0]."<br>". $data[1] ;
		}

	}
	return $value;


}
function emptyData ($value = ''){
	if (isset($value)){
		if(empty($value)  || $value == ' '){
			$ret = "-";
			return $ret; 
		}else{
			return $value ;

		}
	}
}
function formatData($value = ''){
	if(isset($value) && !empty($value)){
		 return $value =  date("d/n-G:i", strtotime($value ) );

	}

}



