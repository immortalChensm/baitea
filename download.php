<?php
	
	header("content-type:/text/html;charset=utf8");
	
	$filename = "quhecha.apk";
	
	header("Content-Type:text/html;charset=utf-8");
	header("Content-type:application/force-download");
	header("Content-Type:application/octet-stream");
	header("Accept-Ranges:bytes");
	header("Content-Length:".filesize($filename));//指定下载文件的大小
	header('Content-Disposition:attachment;filename="'.$filename.'"');
	
	readfile($filename);
	
?>
