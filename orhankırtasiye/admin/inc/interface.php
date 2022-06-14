<?php

	require_once("../inc/dbcon.php");
	
	require_once("inc/class.upload.php");
	$user = $_SESSION["user"];

	function head($title) {
		?>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title><?=$title . " - " ?> Yönetici Paneli</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="img/favicon.ico">
		<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
		
		<link href="assets/bootstrap-datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet">
		<?php
	}
	
	function endhead($title){
		?>
		<link rel="stylesheet" href="css/flaty.css">
		<link rel="stylesheet" href="css/flaty-responsive.css">
		
		<link rel="stylesheet" href="assets/trumbowyg/trumbowyg.min.css">
		
		<script type="text/javascript" src="js/jquery-1.11.2.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<?php
	}
	
	function topbar(){
		?>
		
		<div id="theme-setting">
			<a href="#"><i class="fa fa-gears fa fa-2x"></i></a>
			<ul>
				<li>
					<span>Tema</span>
					<ul class="colors" data-target="body" data-prefix="skin-">
						<li class="active"><a class="blue" href="#"></a></li>
						<li><a class="red" href="#"></a></li>
						<li><a class="green" href="#"></a></li>
						<li><a class="orange" href="#"></a></li>
						<li><a class="yellow" href="#"></a></li>
						<li><a class="pink" href="#"></a></li>
						<li><a class="magenta" href="#"></a></li>
						<li><a class="gray" href="#"></a></li>
						<li><a class="black" href="#"></a></li>
					</ul>
				</li>
				<li>
					<span>Üst Bar</span>
					<ul class="colors" data-target="#navbar" data-prefix="navbar-">
						<li class="active"><a class="blue" href="#"></a></li>
						<li><a class="red" href="#"></a></li>
						<li><a class="green" href="#"></a></li>
						<li><a class="orange" href="#"></a></li>
						<li><a class="yellow" href="#"></a></li>
						<li><a class="pink" href="#"></a></li>
						<li><a class="magenta" href="#"></a></li>
						<li><a class="gray" href="#"></a></li>
						<li><a class="black" href="#"></a></li>
					</ul>
				</li>
				<li>
					<span>Sol Bar</span>
					<ul class="colors" data-target="#main-container" data-prefix="sidebar-">
						<li class="active"><a class="blue" href="#"></a></li>
						<li><a class="red" href="#"></a></li>
						<li><a class="green" href="#"></a></li>
						<li><a class="orange" href="#"></a></li>
						<li><a class="yellow" href="#"></a></li>
						<li><a class="pink" href="#"></a></li>
						<li><a class="magenta" href="#"></a></li>
						<li><a class="gray" href="#"></a></li>
						<li><a class="black" href="#"></a></li>
					</ul>
				</li>
				<li>
					<span></span>
					<a data-target="navbar" href="#"><i class="fa fa-square-o"></i> Üst Barı Sabitle</a>
					<a class="hidden-inline-xs" data-target="sidebar" href="#"><i class="fa fa-square-o"></i> Sol Barı Sabitle</a>
				</li>
			</ul>
		</div>

		<div id="navbar" class="navbar">
			<button type="button" class="navbar-toggle navbar-btn collapsed" data-toggle="collapse" data-target="#sidebar">
				<span class="fa fa-bars"></span>
			</button>
			<a class="navbar-brand" href="#">
				<small>
					<i class="fa fa-desktop"></i>
				Yönetici Paneli
				</small>
			</a>

			<ul class="nav flaty-nav pull-right">
				<li class="user-profile">
					<a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
						<img class="nav-user-photo" src="img/user.png" alt="<?=$GLOBALS["user"]["isim"]?>" />
						<span class="hhh" id="user_info">
							<?=$GLOBALS["user"]["isim"]?>
						</span>
						<i class="fa fa-caret-down"></i>
					</a>

					<ul class="dropdown-menu dropdown-navbar" id="user_menu">
						<li class="nav-header"><i class="fa fa-clock-o"></i>Giriş Saati <?=$_SESSION["gsaat"]?></li>
						<li class="divider"></li>
						<li><a href="cikis.php"><i class="fa fa-off"></i>Çıkış</a></li>
					</ul>
				</li>
			</ul>
		</div>
		
		<?php
	}
	
	function leftbar(){
		?>
		
		<div id="sidebar" class="navbar-collapse collapse">
			<ul class="nav nav-list">


			<li class="mn-urunler"><a href="urunlerr.php"><span>Ürün Yönetimi</span></a></li>
			<li class="mn-urunlerkategori"><a href="urunlerkategorii.php"><span>Ürün Kategori Yönetimi</span></a></li>
			<li class="mn-iletisim"><a href="iletisimmesajlarii.php"><span>İletişim Mesajları</span></a></li>
			<li class="mn-hakkimizda"><a href="hakkimizda3.php?islem=liste"><span>Hakkımızda Yönetimi</span></a></li>






			
			<!-- senin yer babuş   -->

	<!--	<li class="mn-gpanel"><a href="index.php"><span>Gösterge Paneli</span></a></li>
			<li class="mn-slider"><a href="slider.php"><span>Slider Yönetimi</span></a></li>
			<li class="mn-refustuslider"><a href="referansustuslider.php"><span>Slider Altı Bannerlar Yönetimi</span></a></li>
			<li class="mn-hakkimizda"><a href="hakkimizda.php?islem=liste"><span>Kurumsal Yönetimi</span></a></li>
			<li class="mn-urunler"><a href="urunler.php"><span>Ürün Yönetimi</span></a></li>
			<li class="mn-urunlerkategori"><a href="urunlerkategori.php"><span>Ürün Kategori Yönetimi</span></a></li>
			<li class="mn-blog"><a href="blog.php?islem=liste"><span>Belgelerimiz Yönetimi</span></a></li>						gerekeni al tablo 
			<li class="mn-katalog"><a href="katalog.php?islem=liste"><span>Online Katalog Yönetimi</span></a></li>
			<li class="mn-haberler"><a href="haberler.php?islem=liste"><span>Haber Yönetimi</span></a></li>
			<li class="mn-referanslar"><a href="referanslar.php"><span>Referans Yönetimi</span></a></li>
			<li class="mn-galeri"><a href="galeri.php?islem=liste"><span>Galeri Yönetimi</span></a></li>
			<li class="mn-iletisim"><a href="iletisim.php"><span>İletişim Bilgileri</span></a></li>
			<li class="mn-mesaj"><a href="iletisimmesajlari.php"><span>İletişim Mesajları</span></a></li>
			<li class="mn-sosyalmedya"><a href="sosyalmedya.php"><span>Sosyal Medya Yönetimi</span></a></li>

	-->		

		<?php
			if ( $_SESSION["user"]["Id"] == 1 ) {
		?>
			<li class="mn-personel"><a href="personel.php"><span>Kullanıcı Yönetimi</span></a></li>
		<?php } ?>



			<!--
				<li class="mn-siteayar"><a href="siteayar.php"><i class="fa fa-phone"></i><span>Adres Bilgileri</span></a></li>
				<li class="mn-kategori"><a href="medyagaleri.php"><i class="fa fa-file-image-o"></i><span>Medya Galeri Ayarları</span></a></li>
			<li class="mn-duyuru"><a href="hizmetler.php"><i class="fa fa-bullhorn"></i><span>Hizmetler Yönetimi</span></a></li>
			<li class="mn-blog"><a href="hakkimizda.php"><i class="fa fa-users"></i><span>Hakkımızda Yönetimi</span></a></li>
			<li class="mn-iletisim"><a href="iletisim.php"><i class="fa fa-facebook"></i><span>İletişim Bilgileri</span></a></li>
				<li class="mn-islemler"><a href="islemler.php"><i class="fa fa-tasks"></i><span>İşlem Listesi</span></a></li>

				<li class="mn-ekibimiz"><a href="ekibimiz.php"><span>Ekibimiz Yönetimi</span></a></li>
			<li class="mn-sss"><a href="sss.php"><span>SSS Yönetimi</span></a></li>
		
			<li class="mn-nedenbiz"><a href="nedenbiz.php"><span>Neden Biz Yönetimi</span></a></li>
			<li class="mn-duyurular"><a href="duyurular.php"><span>Duyurular Yönetimi</span></a></li>
			<li class="mn-basindabiz"><a href="basindabiz.php"><span>Basında Biz Yönetimi</span></a></li>
			<li class="mn-temsilcilikler"><a href="temsilcilikler.php"><span>Temsilcilikler Yönetimi</span></a></li>
			<li class="mn-baskan"><a href="baskan.php"><span>Başkanın Mesajı Yönetimi</span></a></li>
			<li class="mn-misyon"><a href="misyon.php"><span>Misyon Yönetimi</span></a></li>
			<li class="mn-vizyon"><a href="vizyon.php"><span>Vizyon Yönetimi</span></a></li>
			<li class="mn-bagisyap"><a href="bagisyap.php"><span>Bağış Yönetimi</span></a></li>
		
				-->
			</ul>

			<div id="sidebar-collapse" class="visible-lg">
				<i class="fa fa-angle-double-left"></i>
			</div>
			
		</div>
		
		<?php
	}
	
	function footer(){
		?>
		
		<footer>
			<p> &copy; <?=@date("Y");?></p>
		</footer>
		<a id="btn-scrollup" class="btn btn-circle btn-lg" href="#"><i class="fa fa-chevron-up"></i></a>
		
		<?php
	}

	function scripts(){
		?>
		<script>window.jQuery || document.write('<script src="assets/jquery/jquery-2.1.1.min.js"><\/script>')</script>
		<script src="assets/bootstrap/js/bootstrap.min.js"></script>
		<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		
		<script src="assets/bootstrap-datetimepicker/js/Moment.js" type="text/javascript"></script>
		<script src="assets/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" type="text/javascript"></script>
		<?php
	}
	
	
	
	function endscripts(){
		?>
		<script src="assets/trumbowyg/trumbowyg.min.js"></script>
		<script type="text/javascript">
		$(document).ready(function () {
			$('.ckeditor').trumbowyg({
				semantic: false,
				removeformatPasted: true
			});
         });
		</script>
		
		<script src="js/flaty.js"></script>
		<?php
	}
	
?>