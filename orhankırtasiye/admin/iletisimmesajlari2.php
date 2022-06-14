<?php
	require_once("inc/interface.php");
	require_once("inc/checklogin.php");
	
	if($_SESSION["user"]["yetki"] != 0){
		git("index.php");
		die();
	}	

	$baslik = "İletişim Mesajları";
	
	function uzanti($dosya) {
		$uzanti = pathinfo($dosya);
		$uzanti = $uzanti["extension"];
		return $uzanti;
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
							?>
				<div class="row">
				   <div class="col-md-12">
					  <div class="box">
						 <div class="box-title">
							<h3><i class="fa fa-table"></i>İletişim Mesajları Listesi</h3>
							<div class="box-tool">
							   <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
							   <a data-action="close" href="#"><i class="fa fa-times"></i></a>
							</div>
						 </div>
						 <div class="box-content">
						<!--
					 <button type="button" class="btn btn-primary" onclick="javascript:location.href='?islem=ekle';"><i class="fa fa-check"></i> Yeni iletisimmesajlari Bilgisi Ekle</button>
						-->
							<div class="table-responsive">
							   <table class="table table-striped table-hover fill-head">
								  <thead>
									 <tr>
										<th style="width: 20px;">#</th>
										<th style="width: 20%">Ad Soyad</th>
										<th>Mail</th>
										<th>Telefon</th>
										<th>Mesaj</th>
										<th style="width: 100px">İşlem</th>
									 </tr>
								  </thead>
								  <tbody>
									 <?php
									 $veri = tabloCek("iletisimmesajlari2", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
									 ?>
									 <tr>
										<td><?=$i;?></td>
										<td><?=htmlspecialchars($row["ad"]);?></td>
										<td><?=htmlspecialchars($row["mail"]);?></td>
										<td><?=htmlspecialchars($row["telefon"]);?></td>
										<td>
										<a class="btn btn-success btn-sm" href="" data-toggle="modal" data-target="#exampleModal_<?=$row["id"];?>">Oku</a>
											
										
										
										</td>

										
										<td style="width: 150px">
                                            <a class="btn btn-danger btn-sm" href="?islem=sil&Id=<?=$row["id"];?>"><i class="fa fa-trash-o"></i> Sil</a>

                                    	</td>
									 </tr>


									 

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
										 <?=htmlspecialchars($row["mesaj"]);?>
										</div>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
										</div>
										</div>
									</div>
									</div>

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
							
								veriSil("iletisimmesajlari2", "id", $_GET['Id']);
								islemKaydi("iletisimmesajlari Yönetimi Listesi", "bir iletisimmesajlari bilgileri verisi sildi.");
								
								
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
				$('.mn-mesaj').addClass('active');
				$("#avatar").change(function() {
				  $("#avtimg").attr("src","img/demo/avatar/" + $("#avatar").val())
				});
			});
		</script>






	</body>


</html>