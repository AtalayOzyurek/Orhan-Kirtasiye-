<?php
require_once("../inc/interface.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $ad = $_POST["ad"];
   $mail = $_POST["mail"];
   $tel = $_POST["tel"];
   $mesaj = $_POST["mesaj"];

 
   $sutunlar = array("ad", "mail", "telefon", "mesaj");
   $veriler = array($ad, $mail, $tel, $mesaj);
   
   if( veriEkle($sutunlar, $veriler, "iletisimmesajlarii") )
   {
          $box = '<div class="alert alert-success" style="color: #08d608" role="alert">Başarıyla Gönderildi..</div>';

        
      } else {
          $box = '<div class="alert alert-danger" style="color: red" role="alert">Bir hata oluştu..</div>';
      
      }
 }


?>




<!doctype html>
<html lang="en">
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <meta charset="utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.87.0">
    <title>Blog Template · Bootstrap v5.1</title>


    

    <!-- Bootstrap core CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet">

      <style>
         .bd-placeholder-img {
         font-size: 1.125rem;
         text-anchor: middle;
         -webkit-user-select: none;
         -moz-user-select: none;
         user-select: none;
         }

         @media (min-width: 768px) {
         .bd-placeholder-img-lg {
            font-size: 3.5rem;
         }
         }
    </style>

    
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/blog.css" rel="stylesheet">
  </head>

  <body>

  <!--  Burası header alanı yukarıdakı katalog isim arama iletişiö falan   -->
  <?=headd()?>


<main class="container my-4">

  <div class="contant-section px-3 px-lg-4 pb-4"  id="iletişim">
         <h1 class=" text mb-5">İletişim Formu </h1> 
         <div class="row justify-content-around " >
            <div class="col-md-6 d-print-none" >
               <div class="my-2">
                  <center><?=@$box?></center>
                  <form action="?" method="POST">
                     <div class="row">

                        <div class="col-md-6" style="padding: 6px 2px;">
                           <input class="form-control" type="text" id="ad" name="ad" placeholder="Ad-Soyad" required>
                        </div>
                       
                        <div class="col-md-6" style="padding: 6px 2px;">
                           <input class="form-control" type="tel" id="telefon" name="tel" placeholder="Telefon numarası" required>
                        </div>

                        <div class="col-md-12" style="padding: 6px 2px;">
                           <input class="form-control" type="email" id="mail" name="mail" placeholder="E-mail adresiniz" required>
                        </div>

                        <div class="col-md-12" style="padding: 6px 2px;">
                           <textarea class="form-control" id="mesaj" name="mesaj"  placeholder="Mesajın nedir?" required style="width:100%; height:150px;"></textarea>
                        </div>
                        
                     </div>


                     <button class="btn btn-outline-primary mt-2 w-25" type="submit">Gönder</button>

                  </form>
               </div>
            </div>
            <div class="col-3 ml-5">
               
                  <h4 class=" d-inline ">
                     <img  src="../imges/icon/konum.png" alt="mail" style="height:20px; margin-bottom: 5px;">
                     Adres
                  </h4>

                  <div class=" pt-2 pb-5 text-secondary">
                     Samsun/ilkadım 
                  </div>
                  
                  <h4 class=" d-inline"><img  src="../imges/icon/tel.png" alt="mail" style="height:20px; margin-top: -4px;"> Telefon</h4>
                  <div class=" pt-2 pb-5 text-secondary">
                     0543 474 27 93
                  </div>
                  <h5 class=" d-inline"><img  src="../imges/icon/mail.png" alt="mail" style="height:20px; margin-top: -5px; "> E-mail</h5>
                  <div class=" pt-2 pb-5 text-secondary">
                     <a class="text-decoration-none text-secondary" href="mailto:atalayfurkan55@gmail.com"> 
                     atalayfurkan55@gmail.com !!
                     </a>
                  </div>
               
            </div>
         </div>
      </div> 
      <hr class="mb-5">
      
      <div class="row justify-content-center mb-5">
         <div class="col">
            <center>
               <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1499.44790479959!2d36.3119621074884!3d41.26760441793999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4087d87b43c0f2bd%3A0xa3b7223f96eb4905!2sORHAN%20KIRTAS%C4%B0YE!5e0!3m2!1str!2str!4v1630400901706!5m2!1str!2str" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </center>
         </div>
      </div>

</main>



<?=footerr()?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
