<?php
 
namespace App\Controller;

use Yoop\AbstractController;

class ErrorController extends AbstractController
{
    public function print_404() 
    {
        return $this->render('errors/error_404', ["idPage" => "error-404"] );
    }
    
    
    public function print_405() 
    {
        return $this->render('errors/error_405', ["idPage" => "error-405"] );
    }
    

    public function print_forbidden() 
    {
        return $this->render('errors/forbidden', ["idPage" => "forbidden"] );
    }
}
