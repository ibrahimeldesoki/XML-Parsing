<?php
    define('_PATH', dirname(__FILE__));
    $dir = new DirectoryIterator(_PATH."/files/");
?>
<!DOCTYPE html>
<head>
    <link rel="stylesheet" type="text/css" href="table.css">
</head>
<body>
    <table>
            <thead>
            <tr>      
                <th>IP Address</th>
                <th>Email Volume</th>
                <th>Pass</th>
                <th>Fail</th>
                <th>Rate</th>
            </tr>
            </thead>
    <?php
     foreach ($dir as $fileinfo) 
     {
            if (!$fileinfo->isDot()) 
            {
                $file_=  $fileinfo->getFilename(); 
                $xml = simplexml_load_file(_PATH."/files/".$file_);
            if ($xml === false) 
            {
                    echo "Failed loading XML: ";
                    foreach(libxml_get_errors() as $error)
                     {
                         echo "<br>", $error->message;
                     }
            } 
            else 
            {
                ?>
                        <tbody>
                            <?php $dkim = 0;
                                foreach($xml->record as $record) {?>
                                <tr>
                                        <td ><?=$record->row->source_ip?></td>
                                        <td><?=$record ->row->count?></td>
                                        <td><?=($record->row->policy_evaluated->dkim=='pass'?$dkim:0)?></td>
                                        <td><?=($record->row->policy_evaluated->spf=='pass'?'1':0)?></td>
                                        <td><?=($record->row->policy_evaluated->spf=='pass'?'0':0)?></td>
                                </tr>           
<?php
            }
            }
        }
    }
?>
                        </tbody>
    </table>
    </body>
</html>