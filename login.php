<?php
  $errorMessage = '';
 
  if(!empty($_POST)) 
  {
	    define('LOGIN',$_POST['login']);
		define('PASSWORD',$_POST['password']);
    if(!empty($_POST['login']) && !empty($_POST['password'])) 
    {    
        session_start();
		$_SESSION['login'] = LOGIN;
		$_SESSION['password'] = PASSWORD;
        header('Location: analyse.php');
        exit();      
    }
      else
    {
      $errorMessage = 'Veuillez inscrire vos identifiants svp !';
    }
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
  <head>
    <title>CHECK SIMILARITE SKU</title>
<link rel="stylesheet" type="text/css" href="AnalyseStyleForChrome.css" />
<link rel="stylesheet" type="text/css" href="AnalyseStyleForFirefox.css" />
  </head>
  <body>
	<a id='reduire' href="README.pdf">
	<input id='reduire' type='button' value="MANUELLE D'UTILISATION"/>
	</a>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
      <fieldset class="identification">
        <legend>Connectez-vous</legend>		
        <?php
          if(!empty($errorMessage)) 
          {
            echo '<p>', htmlspecialchars($errorMessage) ,'</p>';
          }
        ?>
       <p>
          <label for="login">Login :</label> 
          <input type="text" name="login" id="login" value="" />
        </p>
        <p>
          <label for="password">Mots de passe :</label> 
          <input type="password" name="password" id="password" value="" /> 
          <input type="submit" name="submit" value="Se connecter"/>
        </p>
      </fieldset>
    </form>
  </body>
</html>
