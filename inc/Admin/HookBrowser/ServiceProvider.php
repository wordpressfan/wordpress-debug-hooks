<?php

namespace DebugHooks\Admin\HookBrowser;

use DebugHooks\Dependencies\LaunchpadAutoresolver\ServiceProvider as FrameworkServiceProvider;

class ServiceProvider extends FrameworkServiceProvider
{
    public function get_common_subscribers(): array {
        return [
            \DebugHooks\Admin\HookBrowser\Subscriber::class,
        ];
    }
}
