<?php
define('_PATH', dirname(__FILE__));
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['unzip'])){
        $filename = $_FILES['file']['name'];
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $expensions = array('zip');
        if(in_array(strtolower($ext),$expensions)){
            $tmp_name = $_FILES['file']['tmp_name'];
            $zip = new ZipArchive();
            $res = $zip->open($tmp_name);
            if ($res === TRUE) {
                $path = _PATH."/files/";
                $zip->extractTo($path);
                $zip->close();
                header('Location: '.'parser.php?filename='.$filename);
            } else {
                echo 'Failed To Unzip';
            }
        }
        else{
            echo 'Please Upload file with zip expension';
        }

    }
}

?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST"  enctype="multipart/form-data">
    <label>Upload a Zip File</label>
  
    <div>   
        <br> 
        <input type="file" name="file">
    </div>
    <br>
    <br>
    <div>
        <input type="submit" name="unzip" value="Unizip To Prasing" />
    </div>
</form>
