<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	
	
	$baslik1 = "Slider Yönetimi";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		if($_GET["islem"] == "resimekle"){
			$slider_baslik = $_POST["slider_baslik"];
			$slider_aciklama = $_POST["slider_aciklama"];
			$slider = resimUpload($_FILES["resim"], "", false, "images/slider", "1920,800");

			
			$sutunlar = array("resim","slider_baslik",  "slider_aciklama");
			$veriler = array($slider,$slider_baslik, $slider_aciklama);
			
			if(veriEkle($sutunlar, $veriler, "slider"))
				islemKaydi("Slider", "slider resim ekledi.");
			git("?islem=liste");
		}
		
		if($_GET["islem"] == "resimduzenle"){
			$slider_id = $_POST["slider_id"];
			
			$slider_baslik = $_POST["slider_baslik"];
			$slider_aciklama = $_POST["slider_aciklama"];
			$incelelink = $_POST["incelelink"];
			
			$sutunlar = array("slider_baslik", "slider_aciklama", "incelelink");
			$veriler = array($slider_baslik, $slider_aciklama, $incelelink);
			
			if( !empty( $_FILES["resim"]["name"] ) )
			{
				$eski = veriCek("slider", "resim", "id", $slider_id);
				$slider = resimUpload($_FILES["resim"], $eski["resim"], false, "images/slider", "1920,800");
				
				array_push($sutunlar, "resim");
				array_push($veriler, $slider);
			}
			
			
			if(veriGuncelle($sutunlar, $veriler, "slider", "id", $slider_id))
				islemKaydi("Slider", "slider resmini güncelledi.");
			
			git("?islem=liste");
		}
		if($_GET["islem"] == "resimduzenledil"){
			$slider_id = $_POST["slider_id"];
			$hedef = $_POST["hedef"];
			
			$slider_baslik = $_POST["slider_baslik"];
			$slider_aciklama = $_POST["slider_aciklama"];
			

			$sutunlar = array("slider_baslik_".$hedef, "slider_aciklama_".$hedef);
			$veriler = array($slider_baslik, $slider_aciklama);
			
			if(veriGuncelle($sutunlar, $veriler, "slider", "id", $slider_id))
				islemKaydi("slider", "slider resmini güncelledi.");
			
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
							 <h3><i class="fa fa-bars"></i> Yeni Slider Ekle </h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=resimekle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
							
							 <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Resim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="file" name="resim" class="form-control" data-rule-required="true" data-rule-minlength="3">
									  <br /><p style="color: red;  font-weight: 700;"> Önerilen ; Resim Boyutu</p>
									  <p>
									  - <b style="color: red">(Width) Genişlik : 1920Px (Piksel)</b>
									  <br />
									  - <b style="color: red">(Height) Yükseklik : 800Px (Piksel)</b>
									  </p>
								   </div>
								</div>


								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Resim Başlığı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="slider_baslik" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="slider_aciklama" class="form-control ckeditor"></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İncele Buton Linki</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="incelelink" class="form-control">
								   </div>
								</div>
								<div class="form-group last">
								   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
									  <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Ekle</button>
									  <button type="button" class="btn" onclick="javascript:location.href='?islem=duzenle';">İptal</button>
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
						$getSlider = veriCek("slider", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Slider Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=resimduzenle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="slider_id" value="<?=$_GET["Id"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Mevcut Resim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <a target="_blank" href="../images/slider/<?=$getSlider["resim"]?>"> <img src="../images/slider/<?=$getSlider["resim"]?>" style="max-width: 50%;" /> </a>
									  <input type="file" name="resim" class="form-control" data-rule-minlength="3">
									  <br /><p style="color: red;  font-weight: 700;"> Önerilen ; Resim Boyutu</p>
									  <p>
									  - <b style="color: red">(Width) Genişlik : 1920Px (Piksel)</b>
									  <br />
									  - <b style="color: red">(Height) Yükseklik : 800Px (Piksel)</b>
									  </p>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Başlık</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="slider_baslik" value="<?=$getSlider["slider_baslik"]?>" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="slider_aciklama" class="form-control ckeditor"><?=$getSlider["slider_aciklama"]?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">İncele Buton Linki</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="incelelink" value="<?=$getSlider["incelelink"]?>" class="form-control">
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
						case "dil_duzenle":
						$getSlider = veriCek("slider", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Slider Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=resimduzenledil" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="slider_id" value="<?=$_GET["Id"]?>" />
								<input type="hidden" name="hedef" value="<?=$_GET["dil"]?>" />
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Başlık</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="slider_baslik" value="<?=$getSlider["slider_baslik_{$_GET["dil"]}"]?>" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="slider_aciklama" class="form-control ckeditor"><?=$getSlider["slider_aciklama_{$_GET["dil"]}"]?></textarea>
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
							<h3><i class="fa fa-table"></i> Ana Slider Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ekle';"><i class="fa fa-check"></i> Yeni Slider Ekle</button>
							<br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th style="width: 15%">
										<th style="width: 15%">Başlık</th>
										<th>Açıklama</th>
										<th style="width: 150px">İşlem</th>
									 </tr>
								  </thead>
								  <tbody id="sortable" target="slider">
									 <?php
									 $veri = tabloCek("slider", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
									 ?>
									 <tr id="item-<?=$row["id"];?>">
										<td class="sortable"><?=$i;?></td>
										<td><a target="_blank" href="../images/slider/<?=$row["resim"];?>"><img src="../images/slider/<?=$row["resim"];?>" height="120px" /></td>

										<td><?=$row["slider_baslik"];?></td>
										<td><?=mb_substr($row["slider_aciklama"], 0, 80)?>...</td>
										<td style="width:400px">
										<a class="btn btn-primary btn-sm" href="?islem=dil_duzenle&dil=en&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> İngilizce Düzenle</a>
											<a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Düzenle</a>
										   <a class="btn btn-danger btn-sm" href="?islem=sil&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
										</td>
									 </tr>
									 <?php
									 $i++;
									 }
									 ?>
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
								$getOldImg = veriCek("slider", "id, slider_baslik", "id", $_GET["Id"]);
							
								veriSil("slider", "id", $_GET['Id']);
								islemKaydi("Slider Listesi", "bir slider resimi sildi.");
								
								
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
				$('.mn-slider').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>