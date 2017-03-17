<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function readExcel($archivo='', $ruta='')
{
	include 'PHPExcel/IOFactory.php';
	$objPHPExcel = PHPExcel_IOFactory::load($ruta.$archivo);
	$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
	#var_dump($sheetData);
	return $sheetData;
}
