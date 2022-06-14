<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	error_reporting(0);
	
	if($_SESSION["user"]["yetki"] != 0){
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
            $aciklama = $_POST["aciklama"];
            
			$sutunlar = array("baslik", "aciklama");
			$veriler = array($baslik, $aciklama);
			
			if(veriEkle($sutunlar, $veriler, "hakkimizda3"))
				islemKaydi("urunler", "urunler  ekledi.");
				
			git("?islem=liste");
		}
		
		if($_GET["islem"] == "resimduzenle"){
			$slider_id = $_POST["slider_id"];

			$baslik = $_POST["baslik"];
			$aciklama = $_POST["aciklama"];
			


			$sutunlar = array("baslik","aciklama");
			$veriler = array($baslik, $aciklama);
			
            if( !empty( $_FILES["resim"]["name"] ) )
			{
				$eski = veriCek("hakkimizda3", "resim", "id", $slider_id);
				$slider = resimUpload($_FILES["resim"], $eski["resim"], false, "images/hakkimizda3", "325,300");
				
				array_push($sutunlar, "resim");
				array_push($veriler, $slider);

            }
            
            if(veriGuncelle($sutunlar, $veriler, "hakkimizda3", "id", $slider_id))
            islemKaydi("hakkimizda3", "hakkimizda3 resmi güncellendi.");
			
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
	<body >
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
						$getSlider = veriCek("hakkimizda3", "*", "id", $_GET["id"]);
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
						$getSlider = veriCek("hakkimizda3", "*", "id", $_GET["Id"]);
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
							<h3><i class="fa fa-table"></i> MEsajlar Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
							<button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ekle';"><i class="fa fa-check"></i> Yeni mesaj Ekle</button>
                           
							<br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
                                        <th style="width: 5%;">#</th>
                                     
										<th style="width: 25%">Başlık</th>
                                        <th style="width: 30%">Açıklama</th>
										
										<th style="width: 15%">İşlem</th>
									 </tr>
								  </thead>
								  <tbody id="sortable" target="hakkimizda3">
									 <?php
									 $veri = tabloCek("hakkimizda3", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
									 ?>
									 <tr id="item-<?=$row["id"];?>">
                                        <td class="sortable"><?=$i;?></td>
										<td><?=$row["baslik"];?></td>
										<td>
										<a class="btn btn-success btn-sm" href="" data-toggle="modal" data-target="#exampleModal_<?=$row["id"];?>">Oku</a>
										<!-- Modal -->
									<div class="modal fade" id="exampleModal_<?=$row["id"];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">Mesaj</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
										<?=$row["aciklama"]?>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
										</div>
										</div>
									</div>
									</div>
										
										
									
									
									
									
									</td>
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
                        
                            veriSil("hakkimizda3", "id", $_GET['id']);
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
				$('.mn-hakkimizda').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>