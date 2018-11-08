<?php

namespace App;

/**
 * Интерфейс для результата рендера виджета (информация, необходимая для того, чтобы отобразить виджет на странице)
 */
interface IWidgetRenderResult
{
    /**
     * Возвращает HTML-код виджета, который надо вставить на страницу, чтобы отобразить виджет
     *
     * @return string
     */
    public function getHTMLCode(): string;

    /**
     * Возвращает CSS-код виджета, который надо подключить к HTML-коду виджета. Если виджет не требует CSS-код, то
     * нужно вернуть пустую строку.
     *
     * @return string
     */
    public function getCSSCode(): string;

    /**
     * Возвращает JS-код виджета, который надо подключить к HTML-коду виджета. Если виджет не требует JS-код, то
     * нужно вернуть пустую строку.
     *
     * @return string
     */
    public function getJSCode(): string;

    /**
     * Возвращает список полных адресов (URL) CSS-файлов, которые надо подключить к HTML-коду виджета. Если виджет не
     * требует CSS-файлов, нужно вернуть пустой массив.
     *
     * @return string[]
     * @link http://jsdelivr.com Отсюда можно взять ссылки на CSS-файлы библиотек
     */
    public function getCSSFiles(): array;

    /**
     * Возвращает список полных адресов (URL) JavaScript-файлов, которые надо подключить к HTML-коду виджета. Если
     * виджет не требует JS-файлов, нужно вернуть пустой массив.
     *
     * @return string[]
     * @link http://jsdelivr.com Отсюда можно взять ссылки на JavaScript-файлы библиотек
     */
    public function getJSFiles(): array;
}
