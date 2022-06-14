<?php
require_once("../inc/interface.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $ad = $_POST["ad"];
   $mail = $_POST["mail"];
   $telefon = $_POST["telefon"];
   $mesaj = $_POST["mesaj"];

 
   $sutunlar = array("ad", "mail", "telefon", "mesaj");
   $veriler = array($ad, $mail, $telefon, $mesaj);
   
   if( veriEkle($sutunlar, $veriler, "iletisimmesajlari2") )
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

  

    
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="../css/blog.css" rel="stylesheet">

  <style>
    html, body {
      margin: 0;
    height: 100%;
   
  
}
  </style>
  </head>

  <body>

  <!--  Burası header alanı yukarıdakı katalog isim arama iletişiö falan   -->
  <?=headd()?>

  <!--   body    -->
  <h1>Hakkımızda </h1> 


<div class="container-fluid" >
  <div class="row  " >
    <div class="col-6 " >
 
    </div>
    <div class="col-6 rounded" >
      <h2>Orhan Kırtasiye</h2>
    </div>
    
    .
  </div>
</div>


  




<?=footerr()?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  </body>
</html>
