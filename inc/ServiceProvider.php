<?php

namespace DebugHooks;

class ServiceProvider extends Dependencies\LaunchpadAutoresolver\ServiceProvider
{
    public function get_common_subscribers(): array {
        return [
            MySubscriber::class,
        ];
    }
}
