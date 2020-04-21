<?php
//page 1
session_start();
//when the edit button is clicked go to the edit page
if (isset($_POST['edit'])) {
    $_SESSION['nonprofit'] = $_POST['edit'];
    header('Location: http://localhost/NCCNPapp/edit.php');
}

?>
<!-- first page of the app with the list of nonprofit responses -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="styles/select.css">
</head>
<body>
    <img src = "images/nccnpLogo.svg" alt = "NCCNP Logo" id = "nccnp"/>
    <form method='post' action='select.php' id='buttons' name = 'fileUploadForm' enctype="multipart/form-data">
    <input type='submit' name='update' value='Update List' id ="update">
    </form>
    <section id = "surveyList">
    <form method='post' action='select.php' name = 'editButtonForm' id= 'tableForm' enctype="multipart/form-data">
    <table id="table">
        <tr>
            <th>Nonprofit</th>
            <th>Last Edited</th>
            <th></th>
        </tr> 
        <?php  
            //Go through all the files in the surveys folder and populate the list
            $path = "surveys/";
            $lineNum = 1;
            if ($handle = opendir($path)) {
                while (false !== ($file = readdir($handle))) {
                    if ('.' === $file) continue;
                    if ('..' === $file) continue;
                    //do something with file
                    $nonprofitName = (explode(".", $file))[0];
                    echo "<tr><td>$nonprofitName </td>";
                    $fn = fopen("surveys/$file","r");

                    //Get the edited date from savedata
                    $edited ="N/A";
                    if (file_exists("saveData/$nonprofitName.txt")) {
                        $saveFn = fopen("saveData/$nonprofitName.txt","r");
                        $dateLine = strtok(fgets($saveFn), ';');
                        $edited = substr($dateLine, strpos($dateLine, "=") + 1);
                    }
                    fclose($fn);
                    echo "<td> $edited</td>";
                    echo "<td><button type='submit' name='edit' class='edit' value='$nonprofitName'>Edit</button></td> </tr>";
                }
            }
        ?>
    </table>
    </form>
    </section>
</body>