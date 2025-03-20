<?php

if (!function_exists('module_path')) {
    /**
     * Retorna o caminho absoluto do módulo dentro do diretório app.
     *
     * @param string $module Nome do módulo
     * @param string|null $path Caminho opcional dentro do módulo (ex: "resources/views")
     * @return string
     */
    function module_path(string $module, ?string $path = null): string
    {
        return realpath(base_path("app/$module".($path ? "/$path" : '')));
    }
}
