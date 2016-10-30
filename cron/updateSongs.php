<?php
require('../kernel/core.php');
ini_set('memory_limit', '-1');
set_time_limit(0);
ini_set('upload_max_filesize', '-1');
define('_TMPDIR_',getcwd().'/tmp/updateByApi/');
/* Delete previous data */
function cleanTmp($path)
{
    $path = rtrim( strval( $path ), '/' ) ;
    
    $d = dir( $path );
    
    if( ! $d )
        return false;
    
    while ( false !== ($current = $d->read()) )
    {
        if( $current === '.' || $current === '..')
            continue;
        
        $file = $d->path . '/' . $current;
        
        if( is_dir($file) )
            cleanTmp($file);
        
        if( is_file($file) )
            unlink($file);
    }
    
    rmdir( $d->path );
    $d->close();
    return true;
}
@cleanTmp(_TMPDIR_);
@mkdir(_TMPDIR_);
chmod(_TMPDIR_, 0777);
/* Start the update check */
$lastVersionUrl = 'http://ftp.musicbrainz.org/pub/musicbrainz/data/fullexport/LATEST';
function readLibrary($url)
{
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);	
	$result = curl_exec($ch);
	$resultCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
	if($resultCode != 200) {
		return 'error';
	}
	else
	{
		return $result;
	}
	curl_close($curl);
}
$lastVer = readLibrary($lastVersionUrl);
$webVer = $db->query('SELECT value FROM config WHERE data="musicBrainzVer"')->fetch_row()[0];
if($lastVer != $webVer)
{
	$filesBaseUrl = substr('http://ftp.musicbrainz.org/pub/musicbrainz/data/fullexport/'.$lastVer, 0, -1);
	$filesIncluded = explode(' ',readLibrary($filesBaseUrl.'/MD5SUMS'));
	$fileCount = 0;
	$filesArray = array();
	foreach($filesIncluded as $fileName)
	{
		if($fileCount%2 != 0)
		{
			$filesArray[] = substr($fileName,1);
		}
		$fileCount++;
	}
	/* Start retrieving data from the given files on $filesArray*/
	foreach($filesArray as $fileName)
	{
		/* Fix for the line anti-jumpstyle given format */
		$fileNameFixExplode = explode('.',$fileName);
		$fileNameFix = array_pop($fileNameFixExplode);
		$fileName = str_replace('.'.$fileNameFix,'.bz2',$fileName);
		echo 'Starting download for file: '.$fileName;
		file_put_contents(_TMPDIR_.$fileName, fopen($filesBaseUrl.'/'.$fileName, 'r'));
		echo '<br>';
		echo 'Downloaded file: '.$fileName;
		echo '<br>';
		echo 'Decompressing file: '.$fileName;
		echo '<br>';
		$phar = new PharData(_TMPDIR_.$fileName);
		$filePath = _TMPDIR_.str_replace('.tar.bz2',null,$fileName);
		$phar->extractTo($filePath);
		echo 'File decompressed success: '.$fileName;
		echo '<br>';
		echo 'Deleting file: '.$fileName;
		echo '<br>';
		unlink(_TMPDIR_.$fileName);
		echo 'File deleted succesfully: '.$fileName;
		echo '<br>';
		echo 'Scanning decompressed files on: '.$filePath;
		echo '<br>';
		echo 'Path routing for: '.$filePath;
		echo '<br>';
		$dir = new RecursiveDirectoryIterator($filePath,FilesystemIterator::SKIP_DOTS);
		$it  = new RecursiveIteratorIterator($dir,RecursiveIteratorIterator::SELF_FIRST);
		$it->setMaxDepth(-1);
		foreach ($it as $fileinfo) {
			if ($fileinfo->isDir()) {
				echo '<br>';
				printf("Folder - %s\n", $fileinfo->getFilename());
				echo '<br>';
			} elseif ($fileinfo->isFile()) {
				echo '<br>';
				printf("File From %s - %s\n", $it->getSubPath(), $fileinfo->getFilename());
				echo '<br>';
		}
		}
		echo 'Decompressed files scanned: '.$fileName;
		echo '<br>';
	}
	//$db->query('UPDATE config SET value="'.$lastVer.'" WHERE data="musicBrainzVer"');
}
?>