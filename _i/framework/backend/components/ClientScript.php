<?php

// http://stackoverflow.com/questions/11651861/forcing-script-order-from-registerscript-method-in-yii


/**
 * ClientScript manages Javascript and CSS.
 */
class ClientScript extends CClientScript {}

//        public $scriptLevels = array();
//    
//        /**
//         * Registers a piece of javascript code.
//         * @param string $id ID that uniquely identifies this piece of JavaScript code
//         * @param string $script the javascript code
//         * @param integer $position the position of the JavaScript code.
//         * @param integer $level the rendering priority of the JavaScript code in a position.
//         * @return CClientScript the CClientScript object itself (to support method chaining, available since version 1.1.5).
//         */
//        public function registerScript($id, $script, $position = self::POS_END, $level = 1) {
//            $this->scriptLevels[$id] = $level;
//    		//var_dump($this->scriptLevels);
//            return parent::registerScript($id, $script, $position);
//        }
//    
//        /**
//         * Renders the registered scripts.
//         * Overriding from CClientScript.
//         * @param string $output the existing output that needs to be inserted with script tags
//         */
//        public function render(&$output) {
//            if (!$this->hasScripts)
//                return;
//    
//            $this->renderCoreScripts();
//    
//            if (!empty($this->scriptMap))
//                $this->remapScripts();
//    
//            $this->unifyScripts();
//    
//            //===================================
//            //Arranging the priority
//            $this->rearrangeLevels();
//            //===================================
//    
//            $this->renderHead($output);
//            if ($this->enableJavaScript) {
//                $this->renderBodyBegin($output);
//                $this->renderBodyEnd($output);
//            }
//        }
//    
//    
//        /**
//         * Rearrange the script levels.
//         */
//        public function rearrangeLevels() {
//            $scriptLevels = $this->scriptLevels;
//            foreach ($this->scripts as $position => &$scripts) {
//                $newscripts = array();
//                $tempscript = array();
//                foreach ($scripts as $id => $script) {
//                    $level = isset($scriptLevels[$id]) ? $scriptLevels[$id] : 1;
//                    $tempscript[$level][$id] = $script;
//                }
//                foreach ($tempscript as $s) {
//                    foreach ($s as $id => $script) {
//                        $newscripts[$id] = $script;
//                    }
//                }
//                $scripts = $newscripts;
//            }
//        }
//    }
