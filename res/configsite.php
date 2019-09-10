<?php
use \vCode\Model\User;
use \vCode\Model\Information;
use \vCode\SystemConfigure;

function getNameSite()
{
	return SystemConfigure::SITENAME;
}
function getFaviconSite()
{   
	$nameSite = "<link rel='shortcut icon' href='http://catalogoclaro.comercial.ws/mondo/res/assets/ar2/favicon.png' >"; 
	return $nameSite;
}
function baseUrl(){

return SystemConfigure::BASEURL; 
}
function getSpanRequired()
{
	$span = "<span class='text-required'>*</span>";
	return $span;
}
function getFormatcss2() 
{
    $dataCss ='';
    
// $dataCss .= "<link rel='stylesheet' href='".SystemConfigure::BASEURL ."res/assets/ar2/assets/bootstrap/css/bootstrap.min.css'>";
$dataCss .= "<link rel='stylesheet'  href='/../../mondo/res/assets/ar2/assets/bootstrap/css/bootstrap.min.css'>";
$dataCss .=     "<link rel='stylesheet'  href='/../../mondo/res/assets/ar2/css/style.css'>";
 $dataCss .=    "<link rel='stylesheet' href='https://kit-pro.fontawesome.com/releases/v5.10.1/css/pro.min.css'>";


    if (isset($dataCss) && !empty($dataCss)){
        return $dataCss ; 
        
    } else{
       Information::setError_general("Carregar os arquivos css"); 
    }

}

function getFormatjs2() {
$dataJs ="";

$dataJs .="<script src='/../../mondo/res/assets/ar2/js/jquery.js'></script>";
    $dataJs .="<script src='/../../mondo/res/assets/ar2/assets/bootstrap/js/bootstrap.min.js'></script>";

     $dataJs .="<script src='/../../mondo/res/assets/ar2/js/index.js'></script>";
    $dataJs .="<script src='/../../mondo/res/assets/ar2/js/ajax.js'></script>";

    if (isset($dataJs) && !empty($dataJs)){
        return $dataJs ; 
    } else{
       Information::setError_general("Carregar os arquivos Js"); 
    }

}

function getFormatBaseUrl($attr , $url){
    if (!empty($attr) && !empty($url) ) {
        $newUrl = "{$attr}=". SystemConfigure::BASEURL . $url ;
        return $newUrl ;
    }

}













