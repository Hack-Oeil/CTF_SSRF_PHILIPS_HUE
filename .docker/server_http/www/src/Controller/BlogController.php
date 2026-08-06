<?php
namespace App\Controller;

use Yoop\AbstractController;

class BlogController extends AbstractController
{
    public function index() 
    {
        return $this->render('home');
    }
}
