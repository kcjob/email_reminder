<?php
  namespace UserSessions;

  //require_once('../vendor/autoload.php');

  class EmailTemplateView {

    private $twig;

    public function __construct()
    {
      $loader = new \Twig_Loader_Filesystem('templates');
      $this->twig = new \Twig_Environment($loader);
      return  $this-> twig;
    }

    public function generateView($objValues)
    {
      return $this->twig->render('emailremind.html', $objValues);
    }

}
