<?php
$configures['application']['path_dir'] = '/path/dir/'; // exp: /pujacms/
$configures['application']['static_server'] = '/static/url/'; // relative link for static resources, exp: //domain.com/media/
$configures['application']['upload_server'] = '/upload/url/'; // relative link uploaded files by CMS;

$configures['session']['saveHandler'] ='File';
$configures['session']['savePath'] ='/var/tmp/';
$configures['session']['enabled'] = true;

$configures['bobwebservice']['url'] = 'http://domain/path/to/cms/?module=webservice&ctrl=alice';
$configures['bobwebservice']['token'] = '<bob token>';
