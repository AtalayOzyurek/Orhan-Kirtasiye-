<?php 
	
	require_once("../inc/dbcon.php");

   $showError = false;
   $errormsg ="";
   if(isset($_POST["username"]) && isset($_POST["password"])){
   	$u = str_replace("'","\'",$_POST["username"]);
    $p = str_replace("'","\'",$_POST["password"]);

        $sorgu = "SELECT * FROM personel WHERE kadi='$u' AND sifre='$p' LIMIT 1;";
	
   	$loginControl = $db->query($sorgu, PDO::FETCH_ASSOC);
   	if( $loginControl->rowCount() > 0 ) {
   		$loginControl = $db->query($sorgu)->fetch(PDO::FETCH_ASSOC);
   		
   		$_SESSION["userlogin"] = true;
   		$_SESSION["user"] = $loginControl;	
   		$_SESSION["gsaat"] = @date('h:i:s');
   		
   		$query = $db->prepare("INSERT INTO islemler SET
   		tarih = ?,
   		personel = ?,
   		tur = ?,
   		aciklama = ?");
   		$insert = $query->execute(array(
   			 @date("Y-m-d H:i:s"),
   			 $loginControl["Id"],
   			 "Giriş",
   			 $loginControl["isim"]." sisteme giriş yaptı."
   		));
   		if ( $insert ){
   			git("index.php");
   			exit();
   		} else {
   			$showError=true;
   		}
   	} else {
   		$showError=true;
   	}
   }
   ?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
      <title>Giriş - Yönetici Paneli</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="shortcut icon" href="img/favicon.ico">
      <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
      <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="assets/gritter/css/jquery.gritter.css">
      <link rel="stylesheet" href="css/flaty.css">
      <link rel="stylesheet" href="css/flaty-responsive.css">
   </head>
   <body class="login-page">
      <div class="login-wrapper">
         <div class="alert alert-danger <?=($showError)?"":"hidden"?>" style="width:340px; margin:auto;" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            Geçersiz bir kullanıcı adı veya parola girdiniz !
         </div>
         <form id="form-login" action="" method="post">
            <h3>Yönetici Paneli</h3>
            <hr/>
            <div class="form-group">
               <div class="controls">
                  <input type="text" name="username" id="username" placeholder="Kullanıcı Adı" class="form-control" data-rule-required="true" data-rule-minlength="3" />
               </div>
            </div>
            <div class="form-group">
               <div class="controls">
                  <input type="password" name="password" id="password" placeholder="Şifre" class="form-control" data-rule-required="true" data-rule-minlength="4" />
               </div>
            </div>
            <div class="form-group hidden">
               <div class="controls">
                  <label class="checkbox">
                  <input type="checkbox" value="remember" /> Beni Hatırla
                  </label>
               </div>
            </div>
            <div class="form-group">
               <div class="controls">
                  <button type="submit" class="btn btn-primary form-control">Giriş Yap</button>
               </div>
            </div>
         </form>
      </div>
      <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script>window.jQuery || document.write('<script src="assets/jquery/jquery-2.1.1.min.js"><\/script>')</script>
      <script src="assets/bootstrap/js/bootstrap.min.js"></script>
      <script src="assets/jquery-validation/dist/jquery.validate.min.js"></script>
      <script src="assets/jquery-validation/dist/additional-methods.min.js"></script>
      <script src="assets/gritter/js/jquery.gritter.js"></script>
      <script type="text/javascript">
         $(function() {
         	if (jQuery().validate) {
         		var removeSuccessClass = function(e) {
         			$(e).closest('.form-group').removeClass('has-success');
         		}
         		var $validator = $('#form-login').validate({
         			errorElement: 'span',
         			errorClass: 'help-block',
         			errorPlacement: function(error, element) {
         				if(element.parent('.input-group').length) {
         					error.insertAfter(element.parent());
         				} else if (element.next('.chosen-container').length) {
         					error.insertAfter(element.next('.chosen-container'));
         				} else {
         					error.insertAfter(element);
         				}
         			},
         			focusInvalid: false,
         			ignore: "",
         
         			invalidHandler: function (event, validator) {             
         				var el = $(validator.errorList[0].element);
         				if ($(el).hasClass('chosen')) {
         					$(el).trigger('chosen:activate');
         				} else {
         					$(el).focus();
         				}
         			},
         
         			highlight: function (element) {
         				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
         			},
         
         			unhighlight: function (element) {
         				$(element).closest('.form-group').removeClass('has-error');
         				setTimeout(function(){removeSuccessClass(element);}, 3000);
         			},
         
         			success: function (label) {
         				label.closest('.form-group').removeClass('has-error').addClass('has-success');
         			}
         		});
         		var $validator = $('#form-forgot').validate({
         			errorElement: 'span',
         			errorClass: 'help-block',
         			errorPlacement: function(error, element) {
         				if(element.parent('.input-group').length) {
         					error.insertAfter(element.parent());
         				} else if (element.next('.chosen-container').length) {
         					error.insertAfter(element.next('.chosen-container'));
         				} else {
         					error.insertAfter(element);
         				}
         			},
         			focusInvalid: false,
         			ignore: "",
         
         			invalidHandler: function (event, validator) {   
         				var el = $(validator.errorList[0].element);
         				if ($(el).hasClass('chosen')) {
         					$(el).trigger('chosen:activate');
         				} else {
         					$(el).focus();
         				}
         			},
         
         			highlight: function (element) {
         				$(element).closest('.form-group').removeClass('has-success').addClass('has-error');
         			},
         
         			unhighlight: function (element) {
         				$(element).closest('.form-group').removeClass('has-error');
         				setTimeout(function(){removeSuccessClass(element);}, 3000);
         			},
         
         			success: function (label) {
         				label.closest('.form-group').removeClass('has-error').addClass('has-success');
         			}
         		});
         	}
         });
      </script>
   </body>
</html>