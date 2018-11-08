<?php

namespace App;

/**
 * Интерфейс виджета
 */
interface IWidget
{
    /**
     * Возвращает начальные настройки виджета. Список, который возвращает этот метод, определяет список настроек виджета
     * в интерфейсе приложения.
     *
     * @return string[] Ключи — названия настроек, значения — значения настроек (строки).
     */
    public static function getInitialConfig(): array;

    /**
     * Создаёт объект виджета, чтобы потом вызвать у него метод `render`
     *
     * @param string[] $config Настройки виджета (в том формате, который возвращает метод `getInitialConfig`)
     * @param App $app Объект ядра сайта
     * @return static Объект этого же класса
     */
    public static function create(array $config, App $app): self;

    /**
     * Рендерит виджет, то есть возвращает информацию, которая необходима для того, чтобы отобразить виджет на странице.
     *
     * Чтобы исполнить PHP-код и получить результат в строку, можно использовать
     * `$app->renderer->fetch('widget/myView.php')`, где `$app` — ядро сайта, полученное ранее в методе `create`.
     *
     * @return IWidgetRenderResult
     */
    public function render(): IWidgetRenderResult;
}
