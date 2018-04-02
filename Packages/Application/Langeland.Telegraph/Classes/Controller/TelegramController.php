<?php
namespace Langeland\Telegraph\Controller;

/*
 * This file is part of the Langeland.Telegraph package.
 */

use Langeland\Telegraph\Domain\Model\Telegram;
use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;

class TelegramController extends ActionController
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
    public function sendAction($token, $messages)
    {
        $html = '<h1>Hello World!!</h1>';
        $telegram = new Telegram();
    }
}
