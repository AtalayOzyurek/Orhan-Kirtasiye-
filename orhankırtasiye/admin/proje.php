<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	
	
	$baslik1 = "Proje Yönetimi";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		if($_GET["islem"] == "resimekle"){
            
            
			$baslik = $_POST["baslik"];
            $aciklama = $_POST["aciklama"];
			//sen yazıyorsun 
			$prog_dil= $_POST["prog_dil"];
			$tur = $_POST["tur"];
			$baglanti = $_POST["baglanti"];

            $resim = resimUpload($_FILES["resim"], "", false, "images/proje", "800,550");
			
			$sutunlar = array("resim", "baslik", "aciklama", "prog_dil", "tur", "baglanti");
			$veriler = array($resim, $baslik, $aciklama, $prog_dil, $tur, $baglanti);
			
			if(veriEkle($sutunlar, $veriler, "proje"))
				islemKaydi("proje", "yazı ekledi.");
			git("?islem=liste");
		}
		
		if($_GET["islem"] == "resimduzenle"){
			$slider_id = $_POST["slider_id"];

			$baslik = $_POST["baslik"];
            $aciklama = $_POST["aciklama"];
			// sen yazdınn tekrar 
			$prog_dil= $_POST["prog_dil"];
			$tur = $_POST["tur"];
			$baglanti = $_POST["baglanti"];

			$sutunlar = array("baslik", "aciklama", "prog_dil", "tur", "baglanti");
			$veriler = array($baslik, $aciklama, $prog_dil, $tur, $baglanti);
			
            if( !empty( $_FILES["resim"]["name"] ) )
			{
				$eski = veriCek("proje", "resim", "id", $slider_id);
				$slider = resimUpload($_FILES["resim"], $eski["resim"], false, "images/proje", "800,550");
				
				array_push($sutunlar, "resim");
				array_push($veriler, $slider);

            }
            
            if(veriGuncelle($sutunlar, $veriler, "proje", "id", $slider_id))
            islemKaydi("proje", "proje resmi güncellendi.");
			
			git("?islem=liste");
        }
			if($_GET["islem"] == "resimduzenledil"){
			$slider_id = $_POST["slider_id"];
			$hedef = $_POST["hedef"];
			
			$baslik = $_POST["baslik"];
			$aciklama = $_POST["aciklama"];
			//
			$prog_dil= $_POST["prog_dil"];
			$tur = $_POST["tur"];
			$baglanti = $_POST["baglanti"];
			

			$sutunlar = array("baslik_".$hedef, "aciklama_".$hedef, "prog_dil_".$hedef, "tur_".$hedef, "baglanti_".$hedef);
			$veriler = array($baslik, $aciklama, $prog_dil, $tur, $baglanti);
			
			if(veriGuncelle($sutunlar, $veriler, "proje", "id", $slider_id))
				islemKaydi("proje", "proje resmini güncelledi.");
			
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
							 <h3><i class="fa fa-bars"></i> Yeni Haber Ekle</h3>
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
									  - <b>(Width) Genişlik : 800Px (Piksel)</b>
									  <br />
									  - <b>(Height) Yükseklik : 550Px (Piksel)</b>
									  </p>
								   </div>
								</div>

                             <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Başlık</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="baslik"  class="form-control">
								   </div>
								</div>

                                <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Açıklama</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="aciklama" class="form-control ckeditor"></textarea>
								   </div>
								</div>

								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Programlama Dili</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="prog_dil" class="form-control ckeditor"></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Tür</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="tur" class="form-control ckeditor"></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Bağlantı (URL)</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="baglanti" class="form-control ckeditor"></textarea>
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
						$getSlider = veriCek("proje", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i>Proje Düzenle</h3>
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
									  <a target="_blank" href="../images/proje/<?=$getSlider["resim"]?>"> <img src="../images/proje/<?=$getSlider["resim"]?>" style="max-width: 50%;" /> </a>
									  <input type="file" name="resim" class="form-control" data-rule-minlength="3">
									  <br /><p> Önerilen ; Resim Boyutu</p>
									  <p>
									  - <b>(Width) Genişlik : 800Px (Piksel)</b>
									  <br />
									  - <b>(Height) Yükseklik : 550Px (Piksel)</b>
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
									  <textarea name="aciklama" class="form-control ckeditor"><?=$getSlider["aciklama"]?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Proglamlama Dili</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="prog_dil" class="form-control ckeditor"><?=$getSlider["prog_dil"]?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Tür</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="tur" class="form-control ckeditor"><?=$getSlider["tur"]?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Bağlantı (URL)</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="baglanti" class="form-control ckeditor"><?=$getSlider["baglanti"]?></textarea>
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
						$getSlider = veriCek("proje", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Yazıyı Düzenle</h3>
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
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Proglamlama Dili</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="prog_dil" class="form-control ckeditor"><?=$getSlider["prog_dil{$_GET["dil"]}"]?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Tür</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="tur" class="form-control ckeditor"><?=$getSlider["tur{$_GET["dil"]}"]?></textarea>
								   </div>
								</div>
								<div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Bağlanti (URL)</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea name="baglanti" class="form-control ckeditor"><?=$getSlider["baglanti{$_GET["dil"]}"]?></textarea>
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
							<h3><i class="fa fa-table"></i> Proje Ekle </h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ekle';"><i class="fa fa-check"></i> Yeni Proje Ekle</button>
                           
							<br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
                                        <th style="width: 2%;">#</th>
                                       
										<th style="width: 10%">Başlık</th>
                                        <th style="width: 25%">İçerik</th>
										<th style="width: 20%">Programlama Dili</th>
										<th style="width: 10%">Tür</th>
										<th style="width: 10%">Bağlanti(URL)</th>
										
										<th style="width: 20%">İşlem</th>
									 </tr>
								  </thead>
								  <tbody id="sortable" target="proje">
									 <?php
									 $veri = tabloCek("proje", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
										
									 ?>
									 <tr id="item-<?=$row["id"];?>">
                                        <td class="sortable"><?=$i;?></td>
                                       
										<td><?=$row["baslik"];?></td>
										<td><?=mb_substr($row["aciklama"], 0, 100)?>...</td>
										<td><?=$row["prog_dil"];?></td>
										<td><?=$row["tur"];?></td>
										<td><?=$row["baglanti"];?></td>
										
										
										<td width="400">
										

											<a class="btn btn-primary btn-sm" href="?islem=duzenle&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Düzenle</a>
										   <a class="btn btn-danger btn-sm" href="?islem=ssssil&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
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
                        if(ctype_digit($_GET["Id"])) {
                        
                            veriSil("proje", "id", $_GET['Id']);
                            islemKaydi("proje Listesi", "bir haber sildi.");
                            
                          
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
				$('.mn-proje').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>