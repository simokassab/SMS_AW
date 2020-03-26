<?php
ob_start();
session_start();
include_once('../../classes/contacts.php');
$cr = new contacts();
$result = "";
if (isset($_FILES['excel']) && $_FILES['excel']['error'] == 0) {
    require_once "../../PHPExcel-1.8/Classes/PHPExcel.php";
    $tmpfname = $_FILES['excel']['tmp_name'];
    $excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
    $excelObj = $excelReader->load($tmpfname);
    $worksheet = $excelObj->getSheet(0);
    $lastRow = $worksheet->getHighestRow();
    $errors = array();
    $good = array();
    for ($row = 2; $row <= $lastRow; $row++) {
        $msisdn = $worksheet->getCell('A' . $row)->getValue();

        $fname = $worksheet->getCell('B' . $row)->getValue();
        $lname = $worksheet->getCell('C' . $row)->getValue();
        $email = $worksheet->getCell('D' . $row)->getValue();
        $gender = $worksheet->getCell('E' . $row)->getValue();
        $address = $worksheet->getCell('F' . $row)->getValue();
        if (strlen($msisdn) == '11') {
            $msisdn = substr($msisdn, 1);
            $msisdn = "964" . $msisdn;
        }
        if (strlen($msisdn) == '10') {
            //msisdn = msisdn.substring(1);
            $msisdn = "964" . $msisdn;
        }
        if (strlen($msisdn) == '13') {
            //msisdn = msisdn.substring(1);
            $msisdn = $msisdn;
        }
        $sub = substr($msisdn, 0, 3);
        $code = substr($msisdn, 3, 2);
        //  echo $code."-".strlen($msisdn)."-".$sub."&";
        if ((!is_numeric($msisdn)) && (($msisdn !== NULL) || ($msisdn !== ''))) {
            //echo $worksheet->getCell('A'.$row)->getValue()."<br>";
            continue;
        } else if (!is_numeric($msisdn)) {
            $errors[] .= 'Error in Line ' . $row . " : " . $msisdn . " - not numeric value";
        } else if ($msisdn == NULL) {
            $errors[] .= 'Error in Line ' . $row . " : " . $msisdn . " - null value not allowed";
        } else if ($msisdn == '') {
            $errors[] .= 'Error in Line ' . $row . " : " . $msisdn . " - Empty value not allowed";
        } else if (strlen($msisdn) != 13) {
            $errors[] .= 'Error in Line ' . $row . " : " . $msisdn . " - invalid format";
        } else if ((strlen($msisdn) == 13) && ($sub) != '964') {
            $errors[] .= 'Error in Line ' . $row . " : " . $msisdn . " - International number not allowed";
        } else if ((strlen($msisdn) == 13) && ($sub == '964') && (($code != "78") && ($code != "79"))) {
            $errors[] .= 'Error in Line ' . $row . " : " . $msisdn . " - Not Zain customer ";
        } else {
            $s = $cr->checkExisting($msisdn, $_SESSION['user_id'], $_POST['up_grp']);
            //  echo $s;
            if ($s == 'OK') {
                $cr_add = $cr->insert($fname, $lname, $email, $address, $gender, $_POST['up_grp'] . ",", $msisdn, $_SESSION['user_id']);
                $good[] .= $msisdn;
            } elseif (strpos($s, 'U-') !== false) {
                //$t = $s.explode("-", $s);
                $good[] .= $msisdn;
            } else {
                $result .= '';
            }
            // $cr_add=$cr->insert($fname, $lname, $email, $address, $gender, $_POST['up_grp'].",", $msisdn, $_SESSION['user_id']);
            //  $good[].=$msisdn;
        }
    }
    $result .= "<h3 style='text-align:center;color: #4CB848;'>" . sizeof($good) . " Rows have been Imported successfully</h3><br/>";

    if (sizeof($errors) > 0) {
        $result .= "<h3 style='text-align:center; color: #EB078C;'>Errors:</h3><br/><ul>";
        foreach ($errors as $er) {
            $result .= "<li>" . $er . "</li>";
        }
        $result .= "</ul>";
    }


} else {
    $result = "Error Uploading... please check the support";
}
$result .= "<a href='contacts.php' class='btn btn-primary' style='margin: 10px; color: white !important;'>Contacts page</a>";
echo $result;
?>