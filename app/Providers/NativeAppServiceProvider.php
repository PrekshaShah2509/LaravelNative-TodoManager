<?php

/**
 * NativeAppServiceProvider
 *
 * Configures the NativePHP app: windows, menu bar, shortcuts, etc.
 *
 * @author Preksha Shah
 * @since 2025
 */
namespace App\Providers;

use Native\Laravel\Facades\Window;
use Native\Laravel\Contracts\ProvidesPhpIni;
use Native\Laravel\Facades\MenuBar;
use Native\Laravel\Menu\Menu;
use Native\Laravel\Facades\GlobalShortcut;

class NativeAppServiceProvider implements ProvidesPhpIni
{
    /**
     * Executed once the native application has been booted.
     * Use this method to open windows, register global shortcuts, etc.
     *
     * @author Preksha Shah
     */
    public function boot(): void
    {
        // Create the main window for the Todo App
        Window::open()
            ->title('Todo App')
            ->route('todos.index')
            ->width(375)
            ->height(700)
            ->minWidth(320)
            ->minHeight(568);
    }

    /**
     * Return an array of php.ini directives to be set.
     *
     * @return array
     * @author Preksha Shah
     */
    public function phpIni(): array
    {
        return [
            // Add any custom php.ini directives here
        ];
    }
}
