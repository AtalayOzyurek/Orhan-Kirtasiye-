<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 1){
		git("index.php");
		die();
	}	
	
	$baslik1 = "Personel Yönetimi";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		if($_GET["islem"] == "resimekle"){
			$isim   = $_POST["isim"];
			$kadi   = $_POST["kadi"];
			$yetki   = $_POST["yetki"];
            $sifre  = $_POST["sifre"];
			
			$sutunlar = array("isim", "kadi", "yetki", "sifre");
			$veriler = array($isim, $kadi, $yetki, $sifre);
			
			if(veriEkle($sutunlar, $veriler, "personel"))
				islemKaydi("personel", "Personel ekledi.");
			
			git("?islem=liste");
		}
		
		if($_GET["islem"] == "resimduzenle"){
			$personel_id = $_POST["personel_id"];
			$isim   = $_POST["isim"];
			$kadi   = $_POST["kadi"];
			$yetki   = $_POST["yetki"];
            $sifre  = $_POST["sifre"];
			
			$sutunlar = array("isim", "kadi", "yetki", "sifre" );
			$veriler = array($isim, $kadi, $yetki, $sifre);
			
			
			if(veriGuncelle($sutunlar, $veriler, "personel", "Id", $personel_id))
				islemKaydi("personel", "Personel güncelledi.");
			
			git("?islem=liste");
		}
		
	}
?>
<!DOCTYPE html>
<html>
	<head>

		<?=head($baslik1);?>
		<?=endhead("");?>

	</head>
	<body>

		<?=topbar();?>

		<div class="container" id="main-container">

			<?=leftbar();?>

			<div id="main-content">
				<div class="page-title">
					<div>
						<h1><i class="fa fa-file-o"></i> <?=$baslik1;?></h1>
					</div>
				</div>

				<?php
					switch(@$_GET["islem"]) {
						case "ekle":
				?>

				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Yeni Personel Ekle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=resimekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
						

								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ad Soyad</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="isim" class="form-control">
								   </div>
								</div>

								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kullanıcı Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="kadi" class="form-control">
								   </div>
								</div>


								
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label"> Yetkilendirme </label>
								   <div class="col-sm-9 col-lg-10 controls">
										<input type="checkbox" id="vehicle1" name="yetki" value="1" >
										<label for="vehicle1"> Yerki Var / Yok </label><br>
								   </div>
								</div>
								

								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sifre</label>
								   <div class="col-sm-9 col-lg-10 controls" id="show_hide_password">
									  <input type="password" name="sifre" class="form-control">
									  <div class="input-group-addon">
											<a><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
										</div>
								   </div>
								</div>

								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=liste';">İptal</button>
								   </div>
								</div>

							 </form>

						  </div>
					   </div>
					</div>
				</div>

				<?php
					break;
					case "duzenle":
					$personel = veriCek("personel", "*", "Id", $_GET["Id"]);
				?>
				
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Personel Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=resimduzenle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="personel_id" value="<?=$_GET["Id"]?>" />
								

								


								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Ad Soyad</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="isim" value="<?=$personel["isim"]?>" class="form-control">
								   </div>
								</div>

								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kullanıcı Adı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="kadi" value="<?=$personel["kadi"]?>" class="form-control">
								   </div>
								</div>

								<?php
									if ( $personel["Id"] != 1 ) {
								?>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label"> Yetkilendirme </label>
								   <div class="col-sm-9 col-lg-10 controls">
										<input type="checkbox" id="vehicle1" name="yetki" value="1" <?=($personel["yetki"]=="1")?"checked":""?>>
										<label for="vehicle1"> Yerki Var / Yok </label><br>
								   </div>
								</div>
								<?php } ?>

								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Sifre</label>
								   <div class="col-sm-9 col-lg-10 controls" id="show_hide_password">
									  	<input type="password" name="sifre" value="<?=$personel["sifre"]?>" class="form-control">
									  	<div class="input-group-addon">
											<a><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
										</div>
								   </div>
								</div>

								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Düzenle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=liste';">İptal</button>
								   </div>
								</div>
							 </form>
						  </div>
					   </div>
					</div>
				</div>

				<?php
					break;
					case "liste":
				?>

				<div class="row">
				   <div class="col-md-12">
					  <div class="box">
						 <div class="box-title">
							<h3><i class="fa fa-table"></i> Personel Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ekle';"><i class="fa fa-check"></i> Yeni Personel Ekle</button>
							<br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										
										<th> Ad Soyad </th>
										<th> Kullanıcı Adı </th>
										<th> Sifre </th>
										<th style="width: 150px">İşlem</th>
									 </tr>
								  </thead>
								  <tbody id="sortable" target="personel">
									 <?php
										$veri = tabloCek("personel", "*", "ORDER BY id DESC");
										$i=1;
										foreach( $veri as $row ) {
									 ?>
									 <tr id="item-<?=$row["Id"];?>">
										<td class="sortable"><?=$i;?></td>

										

										<td><?=$row["isim"];?></td>
										<td><?=$row["kadi"];?></td>
										<td>******</td>
										<td>
											<a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["Id"];?>"><i class="fa fa-trash-o"></i> Düzenle</a>
											<?php
												if ( $row["Id"] != 1 ) {
											?>
										   <a class="btn btn-danger btn-sm" href="?islem=sil&Id=<?=$row["Id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
										   <?php } ?>

										</td>
									 </tr>
									 <?php $i++; } ?>
								  </tbody>
							   </table>
							</div>
						 </div>
					  </div>
				   </div>
				</div>
					
				<?php
					break;
					case "sil":
					{
						if(ctype_digit($_GET["Id"])) {
							$getOldImg = veriCek("personel", "Id", "Id", $_GET["Id"]);
						
							veriSil("personel", "Id", $_GET['Id']);
							islemKaydi("Personel Listesi", "bir Personel sildi.");

						}
					}
					git("?islem=liste");
					break;
					default:
						git("?islem=liste");
					break;
				}
				?>
				
				<?=footer();?>
			</div>
		</div>
		<?=scripts();?>
		<script src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
		<script src="assets/jquery-validation/dist/additional-methods.min.js"></script>
		<?=endscripts();?>
		<script src="assets/jquery/edcsmile.js"></script>
		<script>
			$(document).ready(function () {
				$('.mn-personel').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
		<script>
			$(document).ready(function() {
				$("#show_hide_password a").on('click', function(event) {
					event.preventDefault();
					if($('#show_hide_password input').attr("type") == "text"){
						$('#show_hide_password input').attr('type', 'password');
						$('#show_hide_password i').addClass( "fa-eye-slash" );
						$('#show_hide_password i').removeClass( "fa-eye" );
					}else if($('#show_hide_password input').attr("type") == "password"){
						$('#show_hide_password input').attr('type', 'text');
						$('#show_hide_password i').removeClass( "fa-eye-slash" );
						$('#show_hide_password i').addClass( "fa-eye" );
					}
				});
			});
		</script>
	</body>
</html>