<?php
include('class.upload.php');
$msg = '';
$callback = ($_GET['CKEditorFuncNum']);

$handle = new upload($_FILES['upload']);
if ($handle->uploaded) {
    $handle->image_resize         = true;
    $handle->image_x              = 800;
    $handle->image_ratio_y        = true;

    $handle->process('../../uploads/');
    $image_url = '/uploads/' . $handle->file_dst_name;
    if ($handle->processed) {
         $handle->clean();
    } else {
        $msg =  'error : ' . $handle->error;
    }
}
$output = '<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$callback.', "'.$image_url .'","'.$msg.'");</script>';
echo $output;
?>