<?php
namespace NewdichController;
if(isset($_GET['page'])){
    $page = htmlspecialchars($_GET['page']);
    if($page ==="/" || $page ==="index"){
        require_once __DIR__ . "../public/index.html";
    }
}
else{

}
?>