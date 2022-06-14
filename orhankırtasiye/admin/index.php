<?php

/*********************************/
					// Kayrasoft Yazılım //
	/*********************************/


   require_once("inc/interface.php");
   require_once("inc/checklogin.php");
?>
<!DOCTYPE html>
<html>
   <head>
      <?=head("Gösterge Paneli");?>
      <?=endhead("");?>
   </head>
   <body>
      <?=topbar();?>
      <div class="container" id="main-container">
         <?=leftbar();?>
         <div id="main-content">
            <div class="page-title">
               <div>
                  <h1><i class="fa fa-file-o"></i> Hoşgeldiniz <?=$_SESSION["user"]["isim"];?>,</h1>
                  <h4>
                     Bu paneli kullanarak sisteminizi yönetebilir, verilerinizin bazı bölümlerini güncelleyebilir, içerik üzerinde değişiklikler yapabilirsiniz.
                     <br />
                     <br />
                     <strong>TEST</strong> YÖNETİM PANELİ...
                     <br />
                     <br />
                  </h4>
               </div>
            </div>
            <?=footer();?>
         </div>
      </div>
      <?=scripts();?>
      <?=endscripts();?>
   </body>
</html>