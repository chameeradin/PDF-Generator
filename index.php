<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>PDF Generator</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

    </head>
    <body>
        <div class="container" style="padding-top:50px">
            <h2>Generate Your PDF Files</h2>
            <?php
            if(isset($_SESSION['success']))
            {
                echo $_SESSION['success'];
                session_destroy();
            }
            ?>
            <form class="form-inline" method="post" action="pdfgen.php">
                <button type="submit" id="pdf" name="generate_pdf" class="btn btn-primary"><i class="fa fa-pdf" aria-hidden="true"></i>
                Generate PDF</button>
            </form>
            </fieldset>
        </div>
    </body>
</html>