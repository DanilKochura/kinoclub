<?php
//echo 'aaa';
$a = str_replace("\\", "/", __DIR__);

//echo ROOT;
//echo '<img scr="'.ROOT.'uploads/dan.jpg">';
function generate_url($arr)
{
    $page = $arr[0];
    switch($arr[0]) {
        case 'feedback':
            $page = $page . '.php';
            if(isset($arr[1]) and isset($arr[2]))
            {
                $_GET['type']=$arr[1];
                $_GET['page']=$arr[2];
            }

            break;
        case 'profile':

            $page = $page . '.php';
            if(!isset($arr[1]))
            {
                break;
            }
            else
            {
                $_GET['id'] = $arr[1];
            }

            break;
        case 'news':
        case 'admin':
        case 'login':
        case 'logout':
        case 'statistics':
            $page = $page . '.php';
            break;
        case '':
            $page = 'index.php';
            break;
        default:
            $page = 'index.php';
    }
    //echo $page;
    return $page;

}

$uri = $_SERVER['REQUEST_URI'];
//echo $uri;

$uri = parse_url($uri);
//print_r($uri);


$page = explode('/', $uri['path']);
array_shift($page);
array_shift($page);
$a='../';
for($i=1; $i<count($page); ++$i)
{
    $a = $a.'../';
}

define("ROOT", $a);
//print_r($page);
$page = generate_url($page);
$page = 'pages/'.$page;
//echo $page;
require_once $page;
//print_r($_GET);