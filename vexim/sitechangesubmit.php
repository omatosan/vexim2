<?
  include_once dirname(__FILE__) . "/config/variables.php";
  include_once dirname(__FILE__) . "/config/authsite.php";
  include_once dirname(__FILE__) . "/config/functions.php";

  if (isset($_POST[avscan])) {$_POST[avscan] = 1;} else {$_POST[avscan] = 0;}
  if (isset($_POST[spamassassin])) {$_POST[spamassassin] = 1;} else {$_POST[spamassassin] = 0;}
  if (isset($_POST[enabled])) {$_POST[enabled] = 1;} else {$_POST[enabled] = 0;}

  if (isset($_POST[clear])) {
    if (validate_password($_POST[clear], $_POST[vclear])) {
      $query = "UPDATE users SET crypt='".crypt($_POST[clear])."',
   		clear='$_POST[clear]'
		WHERE localpart='$_POST[localpart]' AND
		domain_id='$_POST[domain_id]'";
      $result = $db->query($query);
      if (!DB::isError($result)) {
        header ("Location: site.php?updated=$_POST[domain]");
	die;
      } else {
        header ("Location: site.php?failupdated=$_POST[domain]");
	die;
      }
    } else {
      header ("Location: site.php?badpass=$_POST[domain]");
      die;
    }
  } 

  if (isset($_POST[uid])) {
    $query = "UPDATE domains SET uid='$_POST[uid]',
    		gid='$_POST[gid]',
		quotas='$_POST[quotas]',
		spamassassin='$_POST[spamassassin]',
		avscan='$_POST[avscan]',
		enabled='$_POST[enabled]' WHERE domain='$_POST[domain]'";
    $result = $db->query($query);
    if (!DB::isError($result)) {
      header ("Location: site.php?updated=$_POST[domain]");
      die; 
    } else {
      header ("Location: site.php?failupdated=$_POST[domain]");
      die;
    }
  }

# Just-in-case catchall
header ("Location: site.php?failupdated=$_POST[domain]");
?>
<!-- Layout and CSS tricks obtained from http://www.bluerobot.com/web/layouts/ -->