<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	error_reporting(0);
	
	if($_SESSION["user"]["yetki"] != 1){
		git("index.php");
		die();
	}	
	
	$baslik1 = "Ürünler";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		if($_GET["islem"] == "resimekle"){
			$baslik = $_POST["baslik"];
            $fiyat = $_POST["fiyat"];
            $kategori = $_POST["kategori"];

            $resim = resimUpload($_FILES["resim"], "", false, "imges/kirtasiye", "260,450");
			
			$sutunlar = array("resim", "baslik", "fiyat", "kategori");
			$veriler = array($resim, $baslik, $fiyat, $kategori);
			
			if(veriEkle($sutunlar, $veriler, "urunlerr"))
				islemKaydi("urunler", "urunler  ekledi.");
			git("?islem=liste");
		}
		
		if($_GET["islem"] == "resimduzenle"){
			$slider_id = $_POST["slider_id"];

			$baslik = $_POST["baslik"];
			$fiyat = $_POST["fiyat"];
			$kategori = $_POST["kategori"];


			$sutunlar = array("baslik","fiyat","kategori");
			$veriler = array($baslik, $fiyat, $kategori);
			
            if( !empty( $_FILES["resim"]["name"] ) )
			{
				$eski = veriCek("urunlerr", "resim", "id", $slider_id);
				$slider = resimUpload($_FILES["resim"], $eski["resim"], false, "imges/kirtasiye", "260,450");
				
				array_push($sutunlar, "resim");
				array_push($veriler, $slider);

            }
            
            if(veriGuncelle($sutunlar, $veriler, "urunlerr", "id", $slider_id))
            islemKaydi("urunlerr", "urunlerr resmi güncellendi.");
			
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
							 <h3><i class="fa fa-bars"></i> Yeni Ürün Ekle</h3>
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
									  <br /><p> Önerilen ; Resim Boyutu</p>
									  <p>
									  - <b>(Width) Genişlik : 325Px (Piksel)</b>
									  <br />
									  - <b>(Height) Yükseklik : 300Px (Piksel)</b>
									  </p>
								   </div>
								</div>

                             <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Başlık</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  
									  <textarea name="baslik" class="form-control "></textarea>
								   </div>
								</div>

                                <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Fiyatı: </label>
								   <div class="col-sm-9 col-lg-10 controls">
									 
									  <input type="text" name="fiyat"  class="form-control ">
								   </div>
								</div>
								
								
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kategori</label>
								   <div class="col-sm-9 col-lg-10 controls">
								   <select name="kategori" class="form-control">
										  <?php
												$kategoriler = tabloCek("urunler_kategorii", "*", "");

												foreach($kategoriler as $data) {
													echo "<option value=\"{$data["id"]}\">{$data["baslik"]}</option>";
												}
										  ?>
									  </select>
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
						$getSlider = veriCek("urunlerr", "*", "id", $_GET["id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i>Ürün Düzenle</h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form action="?islem=resimduzenle" id="validation-form" enctype="multipart/form-data" method="POST" class="form-horizontal form-bordered form-row-stripped">
								<input type="hidden" name="slider_id" value="<?=$_GET["id"]?>" />
								
                                <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Mevcut Resim</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <a target="_blank" href="../imges/kirtasiye/<?=$getSlider["resim"]?>"> <img src="../imges/kirtasiye/<?=$getSlider["resim"]?>" style="max-width: 50%;" /> </a>
									  <input type="file" name="resim" class="form-control" data-rule-minlength="3">
									  <br /><p> Önerilen ; Resim Boyutu</p>
									  <p>
									  - <b>(Width) Genişlik : 325Px (Piksel)</b>
									  <br />
									  - <b>(Height) Yükseklik : 300Px (Piksel)</b>
									  </p>
								   </div>
								</div>

                                <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Başlık</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="baslik" value="<?=$getSlider["baslik"]?>" class="form-control">
								   </div>
								</div>

                                <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="fiyat" class="form-control ckeditor"><?=$getSlider["fiyat"]?></textarea>
								   </div>
								</div>
								

								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Kategori</label>
								   <div class="col-sm-9 col-lg-10 controls">
								   <select name="kategori" class="form-control">
										  <?php
												$kategoriler = tabloCek("urunler_kategorii", "*", "");

												foreach($kategoriler as $data) {
													echo "<option value=\"{$data["id"]}\">{$data["baslik"]}</option>";
												}
										  ?>
									  </select>
										 
									
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
						$getSlider = veriCek("urunlerr", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i>Ürün Düzenle</h3>
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
									  <textarea name="fiyat" class="form-control ckeditor"><?=$getSlider["fiyat_{$_GET["dil"]}"]?></textarea>
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
							<h3><i class="fa fa-table"></i> Ürünler Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ekle';"><i class="fa fa-check"></i> Yeni Ürün Ekle</button>
                           
							<br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
                                        <th style="width: 1%;">#</th>
                                        <th style="width: 10%">Resim</th>
										<th style="width: 10%">Başlık</th>
                                        <th style="width: 10%">Açıklama</th>
										<th style="width: 5%">Kategori</th>
										
										<th style="width: 15%">İşlem</th>
									 </tr>
								  </thead>
								  <tbody id="sortable" target="urunlerr">
									 <?php
									 $veri = tabloCek("urunlerr", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
										$kategori = veriCek("urunler_kategorii", "*", "id", $row["kategori"]);
									 ?>
									 <tr id="item-<?=$row["id"];?>">
                                        <td class="sortable"><?=$i;?></td>
                                        <td><a target="_blank" href="../imges/kirtasiye/<?=$row["resim"];?>"><img src="../imges/kirtasiye/<?=$row["resim"];?>" height="120px" /></td>
										<td><?=$row["baslik"];?></td>
										<td><?=mb_substr($row["fiyat"], 0, 100)?>...</td>
										<td><?=$row["kategori"];?></td>
										<td width="800">
								
											<a class="btn btn-primary btn-sm" href="?islem=duzenle&id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Düzenle</a>
										   <a class="btn btn-danger btn-sm" href="?islem=ssssil&id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
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
                    case "ssssil":
                    {
                        if(ctype_digit($_GET["id"])) {
                        
                            veriSil("urunlerr", "id", $_GET['id']);
                            islemKaydi("urunler Listesi", "bir urunler sildi.");
                            
                          
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
				$('.mn-urunler').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>