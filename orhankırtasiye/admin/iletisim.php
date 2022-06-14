<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	
	
	$baslik = "İletişim Yönetimi";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		
		
		if($_GET["islem"] == "veriduzenle"){
			$d_id = $_POST["d_id"];

			$adres = $_POST["adres"];
			$mail = $_POST["mail"];
			$telefon = $_POST["telefon"];
            $map = $_POST["map"];

			$sutunlar = array("adres", "mail", "telefon", "map");
			$veriler = array($adres, $mail, $telefon, $map);
			
			
			if(veriGuncelle($sutunlar, $veriler, "iletisim", "id", "1"))
				islemKaydi("iletisim bilgileri Yönetimi", "iletisim bilgileri verisini güncelledi.");
			
			git("?islem=liste");
		}
		
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<?=head($baslik);?>
		<?=endhead("");?>
	</head>
	<body>
		<?=topbar();?>
		<div class="container" id="main-container">
			<?=leftbar();?>
			<div id="main-content">
				<div class="page-title">
					<div>
						<h1><i class="fa fa-file-o"></i> <?=$baslik;?></h1>
					</div>
				</div>
				<?php
					switch(@$_GET["islem"]) {
						case "ekle":
							?>
				
							<?php
						break;
						case "liste":
                        $getSlider = veriCek("iletisim", "*", "id", "1");
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> İletişim Yönetimi Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=veriduzenle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="d_id" value="<?=$_GET["Id"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Adres</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="adres" value="<?=$getSlider["adres"]?>" class="form-control">
								   </div>
								</div>
                               
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">E-Mail</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="mail" value="<?=$getSlider["mail"]?>" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Telefon</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="telefon" value="<?=$getSlider["telefon"]?>" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Harita</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="map" value="<?=htmlspecialchars($getSlider["map"])?>" class="form-control">
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
						case "sil":
						{
							if(ctype_digit($_GET["Id"])) {
								$getOldImg = veriCek("iletisim", "id", $_GET["Id"]);
							
								veriSil("iletisim", "id", $_GET['Id']);
								islemKaydi("iletisim Yönetimi Listesi", "bir iletisim verisi sildi.");
								
								
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
				$('.mn-iletisim').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>