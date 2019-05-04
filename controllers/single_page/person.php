<?php

namespace Concrete\Package\Concrete5GraphqlWebsocketSample\Controller\SinglePage;

use PageController;

class Person extends PageController {
    public function view() {
        $this->requireAsset('javascript', 'person');
    }
}