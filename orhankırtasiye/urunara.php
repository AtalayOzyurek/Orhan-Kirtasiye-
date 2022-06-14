<?php
require_once("inc/interface.php");

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
    <title>Orhan Kırtasiye</title>   

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
    <link href="css/blog.css" rel="stylesheet">
  </head>
  <body>
    <?=headd()?>
    <div class="container" >
      <div class="row " >
        <div class=" col-sm-12 col-md-12 col-lg-3 col-xl-3  "  >
            <div class="kategori border  pt-3 shadow-lg p-3 mb-5 bg-white rounded"> 
                <h3 class=" text-center mb-3"><a class="linkk text-dark" href="index.php">Kategori</a> </h3>
              <ul class="text-center  ">
              <?php
									 $veri = tabloCek("urunler_kategorii", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {
										
									 ?>
                <li class=" kathov mb-2"><a class="rounded-pill linkk text-dark mb-2" href="kategoridetay.php?id=<?=$row["id"];?>"><?=$row["baslik"];?></a></li>
                <?php
									 $i++;
									 }
							?>

              </ul>
            </div>
            
        </div>


        <div class=" col-sm-12 col-md-12 col-lg-9 col-xl-9 ">
          <div class="urunler border  p-2 shadow-lg p-3 mb-5 bg-white rounded">
          
          <div class="row justify-content-around">
          <?php
							  $filtre = "WHERE 1=1";

                if( isset($_GET["arama"]) )
                {
                  $filtre .= " AND (baslik LIKE '%{$_GET["arama"]}%') ";
                }

                $alt_data = tcmd("SELECT * FROM urunlerr $filtre");
                foreach( $alt_data as $row ) {
                  $kategori = veriCek("urunler_kategorii", "*", "id", $row["kategori"] );

									 ?>
          <div class="card shadow-lg p-3 mb-5 bg-white rounded" style="width: 18rem;" >
                <img src="imges/kirtasiye/<?=$row["resim"];?>" class="card-img-top p-2" alt="...">
                <div class="card-body">
                  <h5 class="card-title "><?=$row["baslik"];?></h5>
                  <p class="card-text d-inline  ">Fiyat : </p>
                  <p class="card-text d-inline "><?=$row["fiyat"];?>  TL</p>
                  <p class="card-text d-block  "> <a href="kategoridetay.php?id=<?=$kategori["id"];?>"><?=$kategori["baslik"];?></a></p>
                  
                 
                </div>
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal-<?=$row["id"];?>">
                    Resmi İncele
                  </button>

                  <!-- Modal -->
                  <div class="modal fade" id="exampleModal-<?=$row["id"];?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 900px !important;" >
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel"> <?=$row["baslik"];?> </h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <img src="imges/kirtasiye/<?=$row["resim"];?>" alt="" style="width:100%;">
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
              <?php
									 }
							?>
            </div>
          </div>
          
        </div>
      </div>
    </div>
      








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <?=footerr()?>
  </body>
  
</html>
