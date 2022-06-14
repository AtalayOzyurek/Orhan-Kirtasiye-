<?php
    $sayfa = "İdeal Lojistik Yönetimi";
    include('../inc/vt.php');
    include('inc/header.php');
    include('head.php');

    if (isset($_POST['sil'])) {
//print_r($_POST);exit();
$silinecekler = implode(', ', $_POST['sil']);

$sorgu = $baglanti->prepare('select * FROM `ideallojistik` WHERE `id` IN (' . $silinecekler . ')');


    $sorgu->execute();
//sorgu çalıştırılıp veriler alınıyor
while ($sonuc = $sorgu->fetch()) {

        @unlink('../images/lojistik/' . $sonuc["foto"]);//eski dosya siliniyor. isteğe bağlı
    }

    $sorgu = $baglanti->prepare('DELETE FROM `ideallojistik` WHERE `id` IN (' . $silinecekler . ')');
    $sorgu->execute();

}


$sorgu = $baglanti->prepare("SELECT * FROM ideallojistik order by sira");
$sorgu->execute();


?>

<head>
    <script language="javascript"> function confirmDel() {
            var agree = confirm("Silmek istediğinizden emin misiniz?\nBu işlem geri alınamaz!");
            if (agree) {
                return true;
            } else {
                return false;
            }
        } </script>
    <script src="js/tumunusil.js"></script>
</head>

	<div class="main-container">
		<div class="pd-ltr-20 xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>İdeal Lojistik Ayarları</h4>
							</div>
							
						</div>
						<div class="col-md-6 col-sm-12 text-right">
							
						</div>
					</div>
				</div>
				<form action="" method="post">
            <!-- <a class="btn btn-primary" href="projeEkle.php">Yeni Proje Ekle</a> !-->

           
            <!-- Logout Modal-->
            <div class="modal fade" id="tumunuSil" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Açıklama</h5>
                            <button class="close" type="button" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-footer">

                            <button type="submit" class="btn btn-danger font-18"><i class="fa fa-trash"> Seçilenleri
                                    sil</i></button>
                            <button class="btn btn-secondary" type="button"
                                    data-dismiss="modal">Kapat
                            </button>

                        </div>
                    </div>
                </div>
            </div>


            <br><br>

            <!-- DataTables Example -->
            <div class="card mb-3">
                <div class="card-header">
                    İdeal Lojistik
                </div>
                <div class="card-body">


                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                            <tr>  
                                <th hidden>ID</th>
                                <th hidden>Sıra</th>
                                <th>Görsel</th>
                                <th>Başlık</th>
                                <th>Açıklama</th>
                                <th>Düzenle</th>
                                <th>Sil</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?php while ($sonuc = $sorgu->fetch()) { ?>
                                <tr>
                                    
                                    <td hidden><?= $sonuc["id"] ?></td>
                                     <td contenteditable="false" onBlur="veriKaydet(this,'sira','<?= $sonuc["id"] ?>')"
                                        onClick="duzenle(this);" hidden><?= $sonuc["sira"] ?></td>
                                    <td><img src="../images/lojistik/<?= $sonuc["foto"] ?>" width="150px"/></td>
                                    <td contenteditable="false" onBlur="veriKaydet(this,'baslik','<?= $sonuc["id"] ?>')"
                                        onClick="duzenle(this);"><?= $sonuc["baslik"] ?></td>
                                    <td>
                                        <a class="btn btn-info" href="#" data-toggle="modal"
                                           data-target="#icerik<?= $sonuc["id"] ?>">Oku</a>
                                        <!-- Logout Modal-->
                                        <div class="modal fade" id="icerik<?= $sonuc["id"] ?>" tabindex="-1"
                                             role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Açıklama</h5>
                                                        <button class="close" type="button" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body"><?= $sonuc["icerik"] ?></div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button"
                                                                data-dismiss="modal">Kapat
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                   
                                    <td><a class="btn btn" href="projeGuncelle.php?id=<?= $sonuc["id"] ?>"><span
                                                    class="fa fa-edit fa-2x"></span></a></td>
                                    <td>
                                        <a class="dropdown-item" href="#" data-toggle="modal"
                                           data-target="#sil<?= $sonuc["id"] ?>"><span class="fa fa-trash fa-2x"></span></a>


                                        <!-- Logout Modal-->
                                        <div class="modal fade" id="sil<?= $sonuc["id"] ?>" tabindex="-1" role="dialog"
                                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Sil</h5>
                                                        <button class="close" type="button" data-dismiss="modal"
                                                                aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">Projeyi silmek istediğinizden emin misiniz?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary pull-left mx-4" type="button"
                                                                data-dismiss="modal">İptal
                                                        </button>
                                                        <a class="btn btn-danger pull-right mx-4"
                                                           href="Sil.php?sayfa=projeler&id=<?= $sonuc["id"] ?>">Sil</a>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                                <?php
                            } //while bitimi
                            ?>
                            </tbody>
                        </table>
        </form>

		</div>
	</div>
	<!-- js -->
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
</body>
</html>