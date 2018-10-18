<?php

/**
 * @var string|null $error
 * @var string[] $widgetConfig
 * @var \App\IWidgetRenderResult $widgetRender
 */

$error = $error ?? null;
$widgetConfig = $widgetConfig ?? [];
$widgetRender = $widgetRender ?? null;

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Мой виджет</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,700,700i&amp;subset=cyrillic" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="./app.css" />
    <?php

    foreach ($widgetRender ? $widgetRender->getCSSFiles() : [] as $cssFile) {
      echo '<link rel="stylesheet" type="text/css" href="'.htmlspecialchars($cssFile).'" />';
    }

    ?>
    <style>
      <?= $widgetRender ? $widgetRender->getCSSCode() : '' ?>
    </style>
  </head>
  <body>
    <div class="app">
      <div class="app__control">
        <form class="app__control-section">
          <div class="app__control-section-title">Настройки виджета</div>
          <?php

          foreach ($widgetConfig as $title => $value) {
            ?>
            <label class="app__setting">
              <span><?= htmlspecialchars($title) ?></span>
              <input type="text" name="widget[<?= htmlspecialchars($title) ?>]" value="<?= htmlspecialchars($value) ?>" />
            </label>
            <?php
          }

          ?>
          <button class="app__settings-button">Применить</button>
        </form>
        <div class="app__control-section" id="envConfig">
          <div class="app__control-section-title">Настройки окружения</div>
          <label class="app__setting">
            <span>Размер шрифта</span>
            <input type="range" name="fontSize" min="8" max="25" step="0.1" value="13" />
          </label>
          <div class="app__setting">
            <span>Цветовая схема</span>
            <div class="app__colors-list"></div>
          </div>
        </div>
      <div class="app__control-section" id="envConfig">
          <div class="app__control-section-title">Обратная связь виджета</div>
          <pre class="app__widget-output"></pre>
      </div>
      </div>
      <div class="app__content background-color-bg color-text">
        <?php

        if ($error !== null) {
          ?>
          <div class="app__content-error">🛑 <?= htmlspecialchars($error) ?></div>
          <?php
        }

        if ($widgetRender) {
          echo $widgetRender->getHTMLCode();
        }

        ?>
      </div>
    </div>

    <script src="./app.js"></script>
    <?php

    foreach ($widgetRender ? $widgetRender->getJSFiles() : [] as $jsFile) {
        echo '<script src="'.htmlspecialchars($jsFile).'"></script>';
    }

    ?>
    <script>
      <?= $widgetRender ? $widgetRender->getJSCode() : '' ?>
    </script>
  </body>
</html>
