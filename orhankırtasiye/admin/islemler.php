<?php
   require_once("inc/interface.php");
   require_once("inc/checklogin.php");
   
   if($_SESSION["user"]["yetki"] != 0){
   	git("index.php");
   	die();
   }
   
   $baslik = "İşlemler";
   ?>
<!DOCTYPE html>
<html>
   <head>
      <?=head($baslik);?>
      <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css">
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
				if( isset($_GET["tarih"]) )
				{
					$tarih = ninja($_GET["tarih"]);
					
					$tarih = @date("Y-m-d 00:00", strtotime($tarih));
					$tarih2 = @date("Y-m-d 23:59", strtotime($tarih));
				} else {
                $tarih = @date("Y-m-d 00:00");
                $tarih2 = @date("Y-m-d 23:59");
               }
               ?>
            <div class="row">
               <div class="col-md-12">
                  <div class="box">
                     <div class="box-title">
                        <h3><i class="fa fa-table"></i> İşlem Listesi</h3>
                        <div class="box-tool">
                           <a data-action="collapse" href="#"><i class="fa fa-chevron-up"></i></a>
                           <a data-action="close" href="#"><i class="fa fa-times"></i></a>
                        </div>
                     </div>
                     <div class="box-content">
                        <form action="" method="GET" class="form-horizontal form-bordered form-row-stripped">
                           <input type="hidden" name="islem" value="liste" />
                           <div class="form-group">
                              <label for="tarih" class="col-sm-3 col-lg-2 control-label">Tarih</label>
                              <div class="col-sm-9 col-lg-10 controls">
                                 <input type="text" name="tarih" placeholder="Tarih seçiniz." value="<?=@date("d-m-Y",strtotime($tarih))?>" data-rule-required="true" id="dp1" class="form-control date-picker" />
                              </div>
                           </div>
                           <div class="form-group last">
                              <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
                                 <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Filtrele</button>
                              </div>
                           </div>
                        </form>
                        <div class="table-responsive">
                           <table class="table table-striped table-hover fill-head">
                              <thead>
                                 <tr>
                                    <th>#</th>
                                    <th>Tarih</th>
                                    <th>Tür</th>
                                    <th>Açıklama</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 <?php
                                    $veri = $db->query("SELECT * FROM islemler WHERE tarih BETWEEN '".$tarih."' AND '".$tarih2."' ORDER BY tarih DESC", PDO::FETCH_ASSOC);
                                    $i=1;
                                    foreach( $veri as $row ) {
                                    ?>
                                 <tr>
                                    <td><?=$i;?></td>
                                    <td><?=$row["tarih"];?></td>
                                    <td><?=$row["tur"];?></td>
                                    <td><?=$row["aciklama"];?></td>
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
            <?=footer();?>
         </div>
      </div>
      <?=scripts();?>
      <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
      <?=endscripts();?>
      <script>
         $(document).ready(function () {
         	$('.mn-islemler').addClass('active');
         });
      </script>
   </body>
</html>