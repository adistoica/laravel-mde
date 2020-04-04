# laravel-mde

## Modern, concise and easy-to-use Markdown editor

`laravel-mde` is based on simplemde's fork version InscrybMDE editor and adapts to Laravel's `markdown` editor. Source address [InscrybMDE] (https://github.com/Inscryb/inscryb-markdown-editor)

## Laravel version

This extension package has been tested and adapted to the stable version above `Laravel 5.5` (versions below` 5.5` are theoretically feasible, but not tested).
> Note：
> The js and css used in this extension use jsdelivr CDN. To ensure availability, it is recommended to download js and css to the local.

## Requirements
This composer package requires for you to install locally the InscrybMDE dependencies (JS & CSS) as well as jQuery.

Or via JSDeliver -- although your app's load times will be slower:

```
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/inscrybmde@1.11.6/dist/inscrybmde.min.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
<script src="https://cdn.jsdelivr.net/npm/inscrybmde@1/dist/inscrybmde.min.js"></script>
<script src="https://cdn.jsdelivr.net/combine/npm/inline-attachment@2/src/inline-attachment.min.js,npm/inline-attachment@2/src/codemirror-4.inline-attachment.min.js"></script>
```

## Installation and configuration

```bash
composer require adrianstoica/laravel-mde dev-master
```
After the dependency installation is complete, if the laravel version is less than 5.6, please add in `app.php`:

```php
'providers' => [
    \AdrianStoica\LaravelMde\EditorServiceProvider::class
],
```

Then, execute the following `artisan` command, select the corresponding option of the editor, and publish the expansion package configuration and other items.
```bash
php artisan vendor:publish --force
```

```php
/**
 * For simplemde configuration options, please refer to the documentation: https://github.com/Inscryb/inscryb-markdown-editor for specific settings
 * Only some important configurable items are listed here
 * Please note that the value of the configuration item here must be a string `true` or` false`
 * /

return [
     'autofocus' => 'true', // autofocus
     'autosave' => 'false', // automatically press save
     'forceSync' => 'true', // force synchronization textarea
     'indentWithTabs' => 'true', // tab alignment
     'minHeight' => '480px', // minimum height
     'maxHeight' => '720px', // Maximum height
     'allowAtxHeaderWithoutSpace' => 'true',
     'strikethrough' => 'true', // strikethrough
     'underscoresBreakWords' => 'true',
     'placeholder' => 'Enter content here ...',
     'singleLineBreaks' => 'true', // Single line break
     'spellChecker' => 'false', // spell checker
     'status' => 'true', // status bar
     'styleSelectedText' => 'true',
     'syncSideBySidePreviewScroll' => 'true', // scroll preview
     'tabSize' => 4,
     'toolbarTips' => 'true',
     'example' => 'true', // open example (can be closed)
];
```

Now you can access the `/ laravel-mde / example` route, and no surprise, you can see the example page provided by the extension package.

Picture upload supports drag and drop, copy and upload.

The editor pictures will be uploaded to the `public / uploads / content` directory by default; the editor-related function configuration is located in the` config / editor.php` file.

## Instructions

Use the following three methods in the `blade` template: `editor_css ()`,`editor_js ()` and `editor_config('param1', 'param2')`
`editor_config ()` needs to pass in two parameters. The first parameter is the id of the textarea synchronized by the editor, and the second parameter is the unique internal id automatically saved by injecting Inscryb.

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Markdown Example</title>
    {!! editor_css() !!}
</head>
<body>
    <div class="container" style="width: 640px; height: auto; margin: 0 auto;">
        <textarea name="" id="meditor"></textarea>
    </div>
    {!! editor_config('meditor','meditor-1') !!}
</body>
</html>
```
