<?php

declare(strict_types=1);

namespace DVCampus\ObserversAndPlugins\Plugin;

class NewStylePageController
{
    public function beforeExecute($subject, $foo, $bar)
    {
        $foo = false;
    }

    public function aroundExecute($subject, $proceed)
    {
        $proceed();
    }

    public function afterExecute($subject, $result)
    {
        return $result;
    }
}
