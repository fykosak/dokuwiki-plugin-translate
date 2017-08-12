<?php

class action_plugin_translate extends DokuWiki_Action_Plugin {
    /**
     * @var helper_plugin_translate
     */
    private $helper;

    public function __construct() {
        $this->helper = $this->loadHelper('translate');
    }

    public function register(Doku_Event_Handler $controller) {
        $controller->register_hook('ACTION_ACT_PREPROCESS', 'BEFORE', $this, 'actPreprocess');

    }

    public function actPreprocess() {
        global $ID, $conf;
        $translations = $this->helper->getAvailableTranslations($ID);

        $conf['lang'] = $translations['lang'];

        $conf['available_lang'] = array_map(function ($value) {
            return [
                'id' => $value['id'],
                'code' => $value['lang'],
                'name' => $this->helper->getLangName($value['lang']),
            ];
        }, $translations['ids']);
    }
}
