<?php
namespace Langeland\Telegraph\Controller;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class StandardController extends ActionController
{

    /**
     * @return void
     */
    public function indexAction()
    {
        $this->view->assign('foos', array(
            'bar', 'baz'
        ));
    }

    /**
     * @return void
     */
    public function printAction()
    {
        $html = '<h1>Hello World!!</h1>';

    }
}
