<?php
define("PATH", $_SERVER['DOCUMENT_ROOT'] . "/");
require_once(PATH . "/inc/dbcon.php");

if ( isset($_GET["tbname"]) ){
	if ( is_array($_POST["item"]) ){		
		foreach ( $_POST["item"] as $key => $value ){
			veriGuncelle(array("siralama"), array($key), $_GET["tbname"], "id", $value);
		}
		$returnMsg = array( 'islemSonuc' => true , 'islemMsj' => 'İçeriklerin sırala işlemi güncellendi' );
	} else {
		$returnMsg = array( 'islemSonuc' => false , 'islemMsj' => 'İçerik sıralama işleminde hata oluştu' );
	}
}

echo json_encode($returnMsg);
?>