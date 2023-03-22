<?php

/* Common Admin extension scripts */
$this->assets->collection('js-global-page')->addJs($this->CxHelper->Route('admin-ext-main-script') . $dynamicVersion);
