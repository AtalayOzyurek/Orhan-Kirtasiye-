<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	
	
	$baslik1 = "Kurumsal";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		if($_GET["islem"] == "resimekle"){
			$baslik = $_POST["baslik"];
			$aciklama = $_POST["aciklama"];
			
			$slider = resimUpload($_FILES["resim"], "", false, "images/hakgaleri", "600,345");
			
			$sutunlar = array("resim", "baslik", "aciklama");
			$veriler = array($slider, $baslik, $aciklama);
			
			if(veriEkle($sutunlar, $veriler, "hakkimizda"))
				islemKaydi("hakkimizda", "hakkimizda resim ekledi.");
			git("?islem=liste");
		}
		
		if($_GET["islem"] == "resimduzenle"){
			$slider_id = $_POST["slider_id"];
			
			$baslik = $_POST["baslik"];
			$aciklama = $_POST["aciklama"];
			
			$sutunlar = array("baslik", "aciklama");
			$veriler = array($baslik, $aciklama);
			
			if( !empty( $_FILES["resim"]["name"] ) )
			{
				$eski = veriCek("hakkimizda", "resim", "id", $slider_id);
				$slider = resimUpload($_FILES["resim"], $eski["resim"], false, "/images/hakgaleri", "600,345");
				
				array_push($sutunlar, "resim");
				array_push($veriler, $slider);
			}
			
			if(veriGuncelle($sutunlar, $veriler, "hakkimizda", "id", $slider_id))
				islemKaydi("hakkimizda", "hakkimizda resmini güncelledi.");
			
			git("?islem=liste");
		}
		if($_GET["islem"] == "resimduzenledil"){
			$slider_id = $_POST["slider_id"];
			$hedef = $_POST["hedef"];
			
			$baslik = $_POST["baslik"];
			$aciklama = $_POST["aciklama"];
			

			$sutunlar = array("baslik_".$hedef, "aciklama_".$hedef);
			$veriler = array($baslik, $aciklama);
			
			if(veriGuncelle($sutunlar, $veriler, "hakkimizda", "id", $slider_id))
				islemKaydi("hakkimizda", "hakkimizda resmini güncelledi.");
			
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
									  - <b style="color: red">(Width) Genişlik : 600Px (Piksel)</b>
									  <br />
									  - <b style="color: red">(Height) Yükseklik : 345Px (Piksel)</b>
									  </p>
								   </div>
								</div>	
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Resim Başlığı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="baslik" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kısa Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea type="text" name="aciklama" class="form-control ckeditor"></textarea>
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
						$getSlider = veriCek("hakkimizda", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Kurumsal Yazısı Düzenle</h3>
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
									  <a target="_blank" href="../images/hakgaleri<?=$getSlider["resim"]?>"> <img src="../images/hakgaleri/<?=$getSlider["resim"]?>" style="max-width: 50%;" /> </a>
									  <input type="file" name="resim" class="form-control" data-rule-minlength="3">
									  <br /><p style="color: red;  font-weight: 700;"> Önerilen ; Resim Boyutu</p>
									  <p>
									  - <b style="color: red">(Width) Genişlik : 600Px (Piksel)</b>
									  <br />
									  - <b style="color: red">(Height) Yükseklik : 345Px (Piksel)</b>
									  </p>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Hakkımızda Başlığı</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="baslik" value="<?=$getSlider["baslik"]?>" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea type="text" name="aciklama" class="form-control ckeditor"><?=$getSlider["aciklama"]?></textarea>
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
						$getSlider = veriCek("hakkimizda", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Kurumsal Yazısı İng Düzenle</h3>
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
									  <input type="text" name="baslik" value="<?=$getSlider["baslik_{$_GET["dil"]}"]?>" class="form-control">
								   </div>
								</div>
							
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="aciklama" class="form-control ckeditor"><?=$getSlider["aciklama_{$_GET["dil"]}"]?></textarea>
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
							<h3><i class="fa fa-table"></i> Kurumsal Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
						 							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 15px;">#</th>
										<th style="width: 15%">Resim</th>
										<th>Başlık</th>
										<th>Açıklama</th>
										<th style="width: 150px">İşlem</th>
									 </tr>
								  </thead>
								  <tbody id="sortable" target="hakkimizda">
									 <?php
									 $veri = tabloCek("hakkimizda", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
									 ?>
									 <tr id="item-<?=$row["id"];?>">
										<td class="sortable"><?=$i;?></td>
										<td><a target="_blank" href="../images/hakgaleri/<?=$row["resim"];?>"><img src="../images/hakgaleri/<?=$row["resim"];?>" height="120px" /></td>
										<td><?=$row["baslik"];?></td>
										<td><?=mb_substr($row["aciklama"], 0, 80)?>...</td>
										<td width="400">
										<a class="btn btn-primary btn-sm" href="?islem=dil_duzenle&dil=en&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> İngilizce Düzenle</a>

											<a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Düzenle</a>
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
								$getOldImg = veriCek("hakkimizda", "id, resim", "id", $_GET["Id"]);
							
								veriSil("hakkimizda", "id", $_GET['Id']);
								islemKaydi("hakkimizda Listesi", "bir hakkimizda resimi sildi.");
								
								@unlink("../images/hakgaleri" . $getOldImg["img"]);
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
				$('.mn-hakkimizda').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>