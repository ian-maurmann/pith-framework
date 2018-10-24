<?php

    # Pith App
    # --------

    namespace Pith\Framework;

    class PithApp
    {
        public $config        = null;
        public $registry      = null;
        public $authenticator = null;
        public $router        = null;
        public $dispatcher    = null;

        function __construct($config, $registry, $authenticator, $router, $dispatcher)
        {
            $this->config        = $config;
            $this->registry      = $registry;
            $this->authenticator = $authenticator;
            $this->router        = $router;
            $this->dispatcher    = $dispatcher;
        }

    }

