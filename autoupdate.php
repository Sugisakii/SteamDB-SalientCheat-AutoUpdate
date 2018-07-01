<?php  
function parseContent($cheat)
{
	$e = explode("\n", $cheat);
	$s = "if( \$UpdateCheck )";
	$s2 = "Welcome to SalienCheat for SteamDB";
	$contenido = '';
	$c = 0;
	$c2 = 0;
	foreach ($e as $item)
	{

		if(strpos($item, $s) !== false && $c == 0)
		{
			$c += 1;
			//$contenido .= "	include_once('./autoupdate.php');".PHP_EOL;
			$contenido .= "	if (UpdateCheck2()) { die(); }". PHP_EOL;
			continue;
		}
		if($c > 0 && 12 > $c)
		{
			$c += 1;
			continue;
		}
		$contenido .= $item.PHP_EOL;
		if(strpos($item, $s2) !== false && $c2 == 0)
		{
			$contenido .= "include_once('./autoupdate.php');".PHP_EOL;
			$c2 = 1;
		}
	}
	return $contenido;
}
function UpdateCheck2()
{
	$source = "https://raw.githubusercontent.com/SteamDatabase/SalienCheat/master/cheat.php";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $source);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	$cheat = curl_exec($ch);
	$error = curl_error($ch); 
	curl_close($ch);

	if($error != '')
	{
		Msg( '-- {lightred} ' . $error);
		return false;
	}

	$md5 = md5($cheat);

	if(!file_exists("./version"))
	{
		$content = parseContent($cheat);
		UpdateScript($content, $md5);
		return true;
	}
	$version = file_get_contents("./version");
	if($version != $md5)
	{
		$content = parseContent($cheat);
		Msg( '-- {lightred}There is an update available!!!.' );
		Msg( '-- {green}The update will be installed' );
		UpdateScript($content, $md5);
		return true;
	}
	return false;
}
function UpdateScript($content, $md5)
{
	echo PHP_EOL;
	file_put_contents("./version", $md5);
	chmod("./cheat.php", 0755);
	file_put_contents("./cheat.php", $content);
	if(function_exists('Msg'))
	{
		Msg('{background-blue}########################');
		Msg( '-- {background-blue}Restarting Script.!!' );
		Msg('{background-blue}########################'.PHP_EOL);
	}
	else
	{
		echo("      ___          ___          ___                   ___          ___          ___               ".PHP_EOL);
		echo("     /  /\        /__/\        /  /\      ___        /  /\        /  /\        /__/|      ___     ".PHP_EOL);
		echo("    /  /:/_       \  \:\      /  /:/_    /  /\      /  /:/_      /  /::\      |  |:|     /  /\    ".PHP_EOL);
		echo("   /  /:/ /\       \  \:\    /  /:/ /\  /  /:/     /  /:/ /\    /  /:/\:\     |  |:|    /  /:/    ".PHP_EOL);
		echo("  /  /:/ /::\  ___  \  \:\  /  /:/_/::\/__/::\    /  /:/ /::\  /  /:/~/::\  __|  |:|   /__/::\    ".PHP_EOL);
		echo(" /__/:/ /:/\:\/__/\  \__\:\/__/:/__\/\:\__\/\:\__/__/:/ /:/\:\/__/:/ /:/\:\/__/\_|:|___\__\/\:\__ ".PHP_EOL);
		echo(" \  \:\/:/~/:/\  \:\ /  /:/\  \:\ /~~/:/  \  \:\/\  \:\/:/~/:/\  \:\/:/__\/\  \:\/:::::/  \  \:\/\ ".PHP_EOL);
		echo("  \  \::/ /:/  \  \:\  /:/  \  \:\  /:/    \__\::/\  \::/ /:/  \  \::/      \  \::/~~~~    \__\::/".PHP_EOL);
		echo("   \__\/ /:/    \  \:\/:/    \  \:\/:/     /__/:/  \__\/ /:/    \  \:\       \  \:\        /__/:/ ".PHP_EOL);
		echo("     /__/:/      \  \::/      \  \::/      \__\/     /__/:/      \  \:\       \  \:\       \__\/  ".PHP_EOL);
		echo("     \__\/        \__\/        \__\/                 \__\/        \__\/        \__\/              ".PHP_EOL);
		echo(PHP_EOL.PHP_EOL);
		echo("Injected code, you can normally start the cheat.php".PHP_EOL);
	}
	sleep(1);
}
if(UpdateCheck2())
{
	die();
}
?>


