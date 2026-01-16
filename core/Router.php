<?php
class Router {
    private $url;
    private $routes = [];

    public function __construct(){
        $this->url=parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    public function add($path, $controller, $method){
        $this->routes[$path]= [$controller, $method];
    }

    public function run(){
        $uri=$this->url;
        if (isset($this->routes[$uri])) {
            [$controllerName, $method]= $this->routes[$uri];
            $controller=new $controllerName();
            $controller->$method();
        } else {
            http_response_code(404);
            echo "page not found";
        }
    }


}
?>