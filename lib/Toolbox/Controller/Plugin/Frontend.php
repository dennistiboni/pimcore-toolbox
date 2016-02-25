<?php

namespace Toolbox\Controller\Plugin;

class Frontend extends \Zend_Controller_Plugin_Abstract {

    /**
     * @var bool
     */
    protected $initialized = false;

    public function preDispatch() {

        if ($this->initialized) {
            return;
        }

        /** @var \Pimcore\Controller\Action\Helper\ViewRenderer $renderer */
        $renderer = \Zend_Controller_Action_HelperBroker::getExistingHelper('ViewRenderer');
        $renderer->initView();

        /** @var \Pimcore\View $view */
        $view = $renderer->view;

        $view->addScriptPath(PIMCORE_PLUGINS_PATH . '/Toolbox/views/scripts');
        $view->addHelperPath(PIMCORE_PLUGINS_PATH . '/Toolbox/lib/Toolbox/View/Helper', 'Toolbox\View\Helper');

        \Pimcore::getEventManager()->attach("toolbox.addAsset", function (\Zend_EventManager_Event $e) {

            $assetHandler = $e->getTarget();
            $assetHandler->appendScript('toolbox-wysiwyg', '/plugins/Toolbox/static/js/wysiwyg.js', array(), array('showInFrontEnd' => false ));

        });

        $this->initialized = true;

    }

}
