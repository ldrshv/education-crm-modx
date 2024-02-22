<?php

//$elementService->addSnippetPath(MODX_CORE_PATH . 'app/snippets/');

zoomx()->getLoader()->addPsr4('App\\Plugins\\', MODX_CORE_PATH . 'app/plugins/');
zoomx()->getLoader()->addPsr4('App\\Controllers\\', MODX_CORE_PATH . 'app/controllers/');
zoomx()->getLoader()->addPsr4('App\\Services\\', MODX_CORE_PATH . 'app/services/');