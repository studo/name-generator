<?php
$config_file = '/var/www/private/configs/name_generator.yml';
require_once('/var/www/private/db_connection/general.php');

$all_seeds    = $database->query_to_list("SELECT word FROM seeds ORDER BY word ASC;");
$all_suffixes = $database->query_to_list("SELECT suffix FROM suffixes ORDER BY suffix ASC;");
//print_r($seeds);
//print_r($suffixes);

if ( isset($_GET['seed']) && $_GET['seed']!='' ) {
    $selected_seeds = $database->query_to_hash_list("SELECT id, word FROM seeds WHERE word = '".mysql_real_escape_string($_GET['seed'])."' ORDER BY word ASC;");
}
elseif ( isset($_GET['seed']) && $_GET['seed']=='' ) {
    $selected_seeds = $all_seeds;
}
else { $selected_seeds = array(); }

if ( isset($_GET['suffix']) && $_GET['suffix']!='' ) {
    $selected_suffixes = $database->query_to_hash_list("SELECT id, suffix FROM suffixes WHERE suffix = '".mysql_real_escape_string($_GET['suffix'])."' ORDER BY suffix ASC;");
}
elseif ( isset($_GET['suffix']) && $_GET['suffix']=='' ) {
    $selected_suffixes = $all_suffixes;
}
else { $selected_suffixes = array(); }

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">
    <head>
        <title>name generator</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <form action="<?php print $_SERVER['PHP_SELF']; ?>" method="get">
            <select name="seed">
                <option value="">-- All Seeds --</option>
<?php foreach ( $all_seeds as $word ) { ?>
                <option value="<?php print $word; ?>"<?php if ($word==$_GET['seed']) { ?> selected="selected"<?php } ?>><?php print $word; ?></option>
<?php } ?>
            </select>
            <select name="suffix">
                <option value="">-- All Suffixes --</option>
<?php foreach ( $all_suffixes as $suffix ) { ?>
                <option value="<?php print $suffix; ?>"<?php if ($suffix==$_GET['suffix']) { ?> selected="selected"<?php } ?>><?php print $suffix; ?></option>
<?php } ?>
            </select>
            <input type="submit" value="Submit" />
        </form>
<?php if (1) { ?>
<?php     foreach ($selected_seeds as $key => $seed) { ?>
        <h3><?php print $seed; ?></h3>
        <ul>
<?php         foreach ($selected_suffixes as $suffix) { ?>
            <li><?php print $seed.$suffix; ?></li>
<?php         } ?>
        </ul>
<?php     } ?>
<?php } ?>
    </body>
</html>