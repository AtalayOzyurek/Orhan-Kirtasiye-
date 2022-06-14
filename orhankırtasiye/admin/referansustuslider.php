<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	
	
	$baslik1 = "Slider Altı Bannerlar Yönetimi";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
	}
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){		
		if($_GET["islem"] == "resimekle"){
            
            
			$link = $_POST["link"];

            $resim = resimUpload($_FILES["resim"], "", false, "images/refustuslider", "481,175");
			
			$sutunlar = array("resim", "link");
			$veriler = array($resim, $link);
			
			if(veriEkle($sutunlar, $veriler, "refustuslider"))
				islemKaydi("refustuslider", "referans ekledi.");
			git("?islem=liste");
		}
		
		if($_GET["islem"] == "resimduzenle"){
			$slider_id = $_POST["slider_id"];

			$link = $_POST["link"];

			$sutunlar = array("link");
			$veriler = array($link);
			
            if( !empty( $_FILES["resim"]["name"] ) )
			{
				$eski = veriCek("refustuslider", "resim", "id", $slider_id);
				$slider = resimUpload($_FILES["resim"], $eski["resim"], false, "images/refustuslider", "481,175");
				
				array_push($sutunlar, "resim");
				array_push($veriler, $slider);

            }
            
            if(veriGuncelle($sutunlar, $veriler, "refustuslider", "id", $slider_id))
            islemKaydi("refustuslider", "banner resmi güncellendi.");
			
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
							 <h3><i class="fa fa-bars"></i> Yeni Görsel Ekle</h3>
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
									  - <b>(Width) Genişlik : 481Px (Piksel)</b>
									  <br />
									  - <b>(Height) Yükseklik : 175Px (Piksel)</b>
									  </p>
								   </div>
								</div>

                             <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Link</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="link"  class="form-control">
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
						$getSlider = veriCek("refustuslider", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i>Görsel Düzenle</h3>
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
									  <a target="_blank" href="../images/refustuslider/<?=$getSlider["resim"]?>"> <img src="../images/refustuslider/<?=$getSlider["resim"]?>" style="max-width: 50%;" /> </a>
									  <input type="file" name="resim" class="form-control" data-rule-minlength="3">
									  <br /><p> Önerilen ; Resim Boyutu</p>
									  <p>
									  - <b>(Width) Genişlik : 481Px (Piksel)</b>
									  <br />
									  - <b>(Height) Yükseklik : 175Px (Piksel)</b>
									  </p>
								   </div>
								</div>

                                <div class="form-group">
								   <label for="kadi" class="col-sm-3 col-lg-2 control-label">Link</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" name="link" value="<?=$getSlider["link"]?>" class="form-control">
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
							<h3><i class="fa fa-table"></i> Görsel Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
						  <!-- <button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ekle';"><i class="fa fa-check"></i> Yeni Görsel Ekle</button> !-->
                           
							<br /><br />
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
                                        <th style="width: 1%;">#</th>
                                        <th style="width: 15%">Resim</th>
										<th style="width: 5%">Link</th>
									
										
										<th style="width: 15%">İşlem</th>
									 </tr>
								  </thead>
								  <tbody id="sortable" target="refustuslider">
									 <?php
									 $veri = tabloCek("refustuslider", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
										
									 ?>
									 <tr id="item-<?=$row["id"];?>">
                                        <td class="sortable"><?=$i;?></td>
                                        <td><a target="_blank" href="../images/refustuslider/<?=$row["resim"];?>"><img src="../images/refustuslider/<?=$row["resim"];?>" height="120px" /></td>
										<td><?=$row["link"];?></td>

										<td>
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
                        
                            veriSil("refustuslider", "id", $_GET['Id']);
                            islemKaydi("slider Listesi", "bir banner sildi.");
                            
                          
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
				$('.mn-refustuslider').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>