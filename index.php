<?php

define('ROOT', 'https://imdibil.ru');
define('PATH', $_SERVER['DOCUMENT_ROOT']);


//define('ROOT', 'http://localhost/imdibil');
/**
 * Sitemap (можно перенести в отдельный файл)
 */
$GLOBALS['sitemap'] = array (
    '_404' => 'page404.php',   // Страница 404</span>
    '/' => 'main.php',   // Главная страница
    '/news' => 'news.php',   // Новости - страница без параметров
    '/profile/?([0-9]+)?' => 'profile.php',  // С числовым параметром
    '/film/?([0-9]+)?' => 'movies.php',  // С числовым параметром
    '/statistics' => 'statistics.php',  //
    '/feedback' => 'feedback.php',  //
    '/logout' => 'logout.php',  //
    '/login' => 'login.php',  //
    '/register' => 'register.php',  //
    '/admin' => 'admin.php',
    '/test' => 'test.php',
    '/game' => 'game/quiz.php',
    '/game/tour' => 'game/tour.php',
    '/special' => 'special.php',
    '/verification/?(.*)?' => 'verification.php',
    // Больше правил
);
// Код роутера
class uSitemap {
    public $title = '';
    public $params = null;
    public $classname = '';
    public $data = null;

    public $request_uri = '';
    public $url_info = array();

    public $found = false;

    function __construct() {
        $this->mapClassName();
    }

    function mapClassName() {

        $this->classname = '';
        $this->title = '';
        $this->params = null;

        $map = &$GLOBALS['sitemap'];
        $this->request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->url_info = parse_url($this->request_uri);
        $uri = urldecode($this->url_info['path']);
        //echo $uri.'<br>';
        $data = false;
        foreach ($map as $term => $dd) {
            $match = array();
            $i = preg_match('@^'.$term.'$@Uu', $uri, $match);
            if ($i > 0) {
                // Get class name and main title part
                $m = explode(',', $dd);
//                print_r($m);
                $data = array(
                    'classname' => isset($m[0])?strtolower(trim($m[0])):'',
                    'title' => isset($m[1])?trim($m[1]):'',
                    'params' => $match,
                );
                break;
            }
        }
        if ($data === false) {
            // 404
//            if (isset($map['_404'])) {
//                // Default 404 page
//                $dd = $map['_404'];
//                $m = explode(',', $dd);
//                $this->classname = strtolower(trim($m[0]));
//                $this->title = trim($m[1]);
//                $this->params = array();
//            }
            $this->found = false;
        } else {
            // Found!
            $this->classname = $data['classname'];
            $this->title = $data['title'];
            $this->params = $data['params'];
            $this->found = true;
        }
//        print_r($this->params);
        return $this;
    }
}
$sm = new uSitemap();
$routed_file = $sm->classname; // Получаем имя файла для подключения через require()
$route = 'pages/'.(file_exists('pages/'.$routed_file) ? $routed_file : 'page404.php');
//echo $route;
//require_once 'config/bd.php';
if($routed_file != 'login.php' and $routed_file != 'register.php')
{
    require_once 'path/header.php';

}

$_GET[0] = ($sm->params[1]) ?: '';

//print_r($sm->params);
//print_r($_GET);
//print_r($_SESSION);
$get = $sm->params;
//require 'model/loader.php';

require_once $route;
if(!in_array($routed_file, ['login.php', 'statistics.php', 'register.php']))
{
    require 'path/footer.php';


}

// Подключаем файл
//echo ROOT.'/image/favicon.ico';
// P.S. Внутри подключённого файла Вы можете использовать параметры запроса,
// которые хранятся в свойстве $sm->params