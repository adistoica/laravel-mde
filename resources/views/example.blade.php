<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Markdown Editor Example</title>
    {!! editor_css() !!}
</head>
<body>
    <div class="container" style="width:720px;height:auto;margin:0 auto;">
        <h2>Markdown Example</h2>
        <textarea name="" id="meditor"></textarea>
    </div>
    {!! editor_config('meditor','meditor-1') !!}
</body>
</html>
