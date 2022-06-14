<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	
	
	$baslik = "İletişim Bölümü";
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
						<h4>
							
						</h4>
					</div>
				</div>
				<?php
					switch(@$_GET["islem"]){
						case "oku":
						$getMessage = veriCek("mesajlar", "*", "id", $_GET["Id"]);
							?>
				<div class="row">
					<div class="col-md-12">
					   <div class="box box-blue">
						  <div class="box-title">
							 <h3><i class="fa fa-bars"></i> Mesaj | Gönderen : <?=$getMessage["ad_soyad"]; ?></h3>
							 <div class="box-tool">
								<a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
								<a data-action="close" href="#"><i class="fa fa-times"></i></a>
							 </div>
						  </div>
						  <div class="box-content">
							 <form id="validation-form" class="form-horizontal form-bordered form-row-stripped">
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Ad Soyad</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" value="<?=$getMessage["ad_soyad"];?>" placeholder="<?=$getMessage["ad_soyad"];?>" class="form-control" readonly>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">E-Mail</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" value="<?=$getMessage["email"];?>" placeholder="<?=$getMessage["email"];?>" class="form-control" readonly>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Tarih</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" value="<?=tarih($getMessage["tarih"]);?>" placeholder="<?=tarih($getMessage["tarih"]);?>" class="form-control" readonly>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Konu</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" value="<?=$getMessage["konu"];?>" placeholder="<?=$getMessage["konu"];?>" class="form-control" readonly>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Telefon</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <input type="text" value="<?=$getMessage["telefon"];?>" placeholder="<?=$getMessage["telefon"];?>" class="form-control" readonly>
								   </div>
								</div>
								<div class="form-group">
								   <label for="isim" class="col-sm-3 col-lg-2 control-label">Mesaj</label>
								   <div class="col-sm-9 col-lg-10 controls">
									  <textarea rows="10" placeholder="<?=$getMessage["mesaj"];?>" class="form-control" readonly><?=$getMessage["mesaj"]; ?></textarea>
								   </div>
								</div>
							 </form>
							 <div class="form-group last">
							   <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
								  <a class="btn btn-danger btn-sm" href="?islem=mesajsil&Id=<?=$getMessage["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
							   </div>
							</div>
						  </div>
					   </div>
					</div>
				</div>
							<?php
						break;
						case "gelenMesajlar":
							?>
				<div class="row">
				   <div class="col-md-12">
					  <div class="box">
						 <div class="box-title">
							<h3><i class="fa fa-table"></i> Gelen Mesajlar</h3>
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
										<th>#</th>
										<th>Ad Soyad</th>
										<th>E-Mail</th>
										<th>Konu</th>
										<th>Telefon</th>
										<th>Tarih</th>
										<th style="width: 150px">İşlemler</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?php
									 $veri = tabloCek("mesajlar", "*", "ORDER BY id desc");
									 $i=1;
									 foreach( $veri as $row ){
									 ?>
									 <tr>
										<td><?=$i;?></td>
										<td><?=$row["ad_soyad"]?></td>
										<td><?=$row["email"]?></td>
										<td><?=$row["konu"]?></td>
										<td><?=$row["telefon"]?></td>
										<td><?=tarih($row["tarih"]);?></td>
										<td>
										   <a class="btn btn-primary btn-sm" href="?islem=oku&Id=<?=$row["id"];?>"><i class="fa fa-edit"></i> Oku</a>
										   <a class="btn btn-danger btn-sm" href="?islem=mesajsil&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>
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
						case "mesajsil":
						if(ctype_digit($_GET["Id"])){
							$eskiveri = veriCek("mesajlar", "*", "id", $_GET["Id"]);
							veriSil("mesajlar", "id", $_GET["Id"]);
							islemKaydi("Personel Silme", "bir mesaj sildi.. ({$eskiveri["ad_soyad"]})");
						}
						git("?islem=gelenMesajlar");
						break;
						default:
							git("?islem=gelenMesajlar");
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
		<script>
			$(document).ready(function () {
				$('.mn-mesajlar').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>
	</body>
</html>