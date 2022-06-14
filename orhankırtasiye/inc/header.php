	<header class="shadow-lg p-3 mb-5 rounded">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid ">
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-danger">     O  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-success ">   r  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-primary">    h  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-warning">    a  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-secondary">  n  </h3></a> &nbsp;&nbsp;&nbsp;
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-danger">     K  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-info">       ı  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-dark">       r  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-warning">    t  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-muted">      a  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-primary">    s  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-secondary">  i  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-success">    y  </h3></a>
    <a class="linkk " href="../index.php"> <h3 class=" shadow p-1 bg-white rounded text-danger">     e  </h3></a> 
      
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2  mx-5 mb-lg-0 nav-men">

        <li class="nav-item dropdown nav-men2 ">
          <a class="navbar-brand dropdown-toggle mx-3" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Kategori
          </a>
          <ul class="dropdown-menu  aa " style="width:300px;" aria-labelledby="navbarDropdown">
                <?php
									 $veri = tabloCek("urunler_kategorii", "*", "ORDER BY id ASC");
									 $i=1;
									 foreach( $veri as $row ) {	
								?>

                <li class="mx-4 my-3  ust-kathov2">
                  <a class=" linkkk text-dark  mb-2" href="../kategoridetay.php?id=<?=$row["id"];?>">
                  <?=$row["baslik"];?>
                  </a>
                </li>
                <?php
									 $i++;
									 }
							  ?>
          </ul>
        </li>
        <li class="nav-item nav-men2 ">
          <a class="navbar-brand mx-3 " href="../pages/iletisim.php">İletişim</a>
        </li>
        <li class="nav-item nav-men3 ">
          <a class="navbar-brand mx-3" href="../pages/hakkimizda.php ">Hakkımızda</a>
        </li>
      </ul>


      <form action="urunara.php" method="GET"class="d-flex mx-3 aramaa">
        <input  name="arama"class="form-control me-4 " type="search" size="50"  placeholder="Arama" aria-label="Search" >
        
      </form>


      
    </div>
  </div>
</nav>
</header>