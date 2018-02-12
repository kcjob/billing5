<?php
namespace Apps;

class TemplateView {
    private $twig;

    public function __construct()
    {
      $loader = new \Twig_Loader_Filesystem('Templates');
      $this->twig = new \Twig_Environment($loader, array('debug' => true));
      $this->twig->addExtension(new \Twig_Extension_Debug());
      return $this-> twig;
    }
    public function generateView($msgDataObject)
    {
        return $this->twig->render('messagebody.html.twig', array( 'dataObject'=>$msgDataObject));
    }
}
