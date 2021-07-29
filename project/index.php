<?php

session_start();

require_once("app/Form.php");
require_once("app/NameGenerator.php");

$form = new app\Form();

if ($_POST) {
    $formData["csrfToken"] = ISSET($_POST["csrf_token"]) ? strip_tags($_POST["csrf_token"]) : "";
    $formData["firstname"] = ISSET($_POST["firstname"]) ? strip_tags($_POST["firstname"]) : "";
    $formData["surname"] = ISSET($_POST["surname"]) ? strip_tags($_POST["surname"]) : "";

    $form->addRule("csrf_token", $formData["csrfToken"], array("validateCSRFToken"));
    $form->addRule("firstname", $formData["firstname"], array("required"));
    $form->addRule("surname", $formData["surname"], array("required"));
    $errors = $form->validate();

    if(!$errors) {   
        $nameGenerator = new app\NameGenerator();
        $middleName = $nameGenerator->generateMiddleName($formData["firstname"], $formData["surname"]);
        //$middleName = $nameGenerator->generateMiddleNameRandom();
    }
}

?>

<!doctype html>
<html lang="en">
    
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>LightFoot Test</title>
    </head>
  
    <body>
        <div class="container">
            <h1 class="text-center">LightFoot Test</h1>

            <form class="mt-5" method = "POST" action = "">
                <?=$form->generateHTMLCSRFToken()?>
                <div class="mb-3">
                    <label for="firstname" class="form-label">* First Name</label>
                    <input type="text" name = "firstname" class="form-control <?=(ISSET($errors["firstname"]))?"is-invalid":""?>" value ="<?=(ISSET($formData["firstname"]))?htmlspecialchars($formData["firstname"],ENT_QUOTES,'UTF-8'):""?>" id="firstname">
                    <?php if(ISSET($errors["firstname"])): ?>
                    <div class="col-sm-3">
                      <small id="passwordHelp" class="text-danger">
                        <?=$errors["firstname"]["required"]?>
                      </small>      
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="surname" class="form-label">* Surname</label>
                    <input type="text" name = "surname" class="form-control <?=(ISSET($errors["surname"]))?"is-invalid":""?>" value ="<?=(ISSET($formData["surname"]))?htmlspecialchars($formData["surname"],ENT_QUOTES,'UTF-8'):""?>" id="surname">
                    <?php if(ISSET($errors["surname"])): ?>
                    <div class="col-sm-3">
                      <small id="passwordHelp" class="text-danger">
                        <?=$errors["surname"]["required"]?>
                      </small>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <small>(* Required)</small>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                
                <?php if(ISSET($errors["csrf_token"])): ?>
                <div class="col mt-3">
                    <small id="passwordHelp" class="text-danger">
                        <?=$errors["csrf_token"]["validateCSRFToken"]?>
                    </small>
                </div>
                <?php endif; ?>
                
            </form>
            
            <?php if(ISSET($middleName)): ?>
            <h2 class="mt-5 text-center">Hello, <?= ucfirst($formData["firstname"])?> <span class="text-primary">"<?=$middleName?>"</span> <?=ucfirst($formData["surname"])?></h2>
            <?php endif; ?>
                            
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
  
</html>
