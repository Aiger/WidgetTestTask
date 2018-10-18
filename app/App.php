<?php

namespace App;

use Slim\Views\PhpRenderer;

/**
 * Ядро сайта
 */
class App
{
    /**
     * @var PhpRenderer Вспомогательный объект, который исполняет PHP-файл и возвращает строку с результатом
     *
     * Пример использования:
     * <pre>
     * $html = $app->renderer->fetch('widget/view.php', ['header' => 'Foo']);
     * </pre>
     */
    public $renderer;

    public function __construct()
    {
        $this->renderer = new PhpRenderer(__DIR__.'/../', [
            'app' => $this
        ]);
    }

    /**
     * Выполняет обработку входящих HTTP-запросов
     */
    public function handle()
    {
        $this->renderWidgetPage();
    }

    /**
     * Обрабатывает запрос к странице виджета
     */
    public function renderWidgetPage()
    {
        /**
         * @var IWidget $widgetClass
         * @var IWidget $widget
         */

        $template = 'app/view.php';
        $widgetClass = 'Widget\Widget';

        if (!class_exists($widgetClass)) {
            echo $this->renderer->fetch($template, ['error' => "Класс виджета отсутствует по адресу `$widgetClass`"]);
            return;
        }

        if (!is_a($widgetClass, IWidget::class, true)) {
            echo $this->renderer->fetch($template, [
                'error' => "Класс виджета `$widgetClass` не является классом, реализующим интерфейс `".IWidget::class."`"
            ]);
            return;
        }

        try {
            $widgetConfig = $this->getWidgetConfig($widgetClass::getInitialConfig(), $_GET['widget'] ?? null);
            $widget = $widgetClass::create($widgetConfig, $this);
            $widgetRender = $widget->render();
        } catch (\Throwable $error) {
            echo $this->renderer->fetch($template, [
                'error' => (string)$error
            ]);
            return;
        }

        echo $this->renderer->fetch('app/view.php', compact('widgetConfig', 'widgetRender'));
    }

    /**
     * Определяет настройки виджета
     *
     * @param string[] $initialConfig Начальные настройки виджета
     * @param string[]|mixed $inputConfig Настройки виджета, полученные из запроса
     * @return string[]
     */
    protected function getWidgetConfig(array $initialConfig, $inputConfig): array
    {
        if (!is_array($inputConfig)) {
            $inputConfig = [];
        }

        return array_intersect_key($inputConfig, $initialConfig) + $initialConfig;
    }
}
