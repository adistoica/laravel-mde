<?php

if (!function_exists('editor_upload')) {
    /**
     * Editor upload
     *
     * @param string $file
     * @param string $rule
     * @param string $path
     * @param mixed $isRandName
     * @param boolean $childPath
     * @return void
     */
    function editor_upload($file, $rule, $path = 'upload', $isRandName = null, $childPath = false) {
        if (!request()->hasFile($file)) {
            $data = ['status_code' => 500, 'message' => 'Upload file is empty'];
            return $data;
        }
        $file = request()->file($file);
        $validator = \Illuminate\Support\Facades\Validator::make(request()->all(), $rule);
        if ($validator->fails()) {
            $data = ['status_code' => 500, 'message' => $validator->errors()->first()];
            return $data;
        }
        if (!$file->isValid()) {
            $data = ['status_code' => 500, 'message' => 'File upload error'];
            return $data;
        }
        // Process upload path
        if ($childPath == true) {
            $path = './' . trim($path, './') . '/' . date('Ymd') . '/';
        } else {
            $path = './' . trim($path, './') . '/';
        }
        is_dir($path) || mkdir($path, 0755, true);
        $oldName = $file->getClientOriginalName();
        $newName = $isRandName ? $isRandName . '.png' : 'image_' . time() . '_' . str_random(10) . '.png';
        if (!$file->move($path, $newName)) {
            return ['status_code' => 500, 'message' => 'Failed to save file'];
        }
        $filePath = trim($path, '.');
        $absolutePath = public_path($filePath) . $newName;
        $publicPath = $filePath . $newName;
        return [
            'status_code' => 200,
            'message' => '上传成功',
            'data' => [
                'old_name' => $oldName,
                'new_name' => $newName,
                'path' => $filePath,
                'absolutePath' => $absolutePath,
                'publicPath' => $publicPath
            ]
        ];
    }
}

if (!function_exists('editor_css')) {
    /**
     *  CSS Related dependencies
     *
     * @return string
     */
    function editor_css() {
        return '
    <link rel="stylesheet" href="/vendor/laravelMde/css/editor.css" />
    <link rel="stylesheet" href="/vendor/laravelMde/css/markdown.css" />
    <style type="text/css">
    .editor-preview img,.editor-preview-side img{box-sizing:border-box;max-width:100%;max-height:100%;box-shadow:0 0 5px rgba(0,0,0,.15);vertical-align:middle}
    </style>';
    }
}

if (!function_exists('editor_config')) {
    /**
     *
     * @param string $editor_id
     * @param string $autosave_id
     * @return void
     */
    function editor_config($autosave_id) {
        $editor_id = 'mde-editor';
        
        return '<script>$(function () {
                var mdeditor = new InscrybMDE({
                    autofocus: ' . config('editor.autofocus') . ',
                    autosave: {
                        enabled: ' . config('editor.autosave') . ',
                        uniqueId: "' . $autosave_id . '",
                        delay: 1000,
                    },
                    blockStyles: {
                        bold: "__",
                        italic: "_"
                    },
                    element: document.getElementById("' . $editor_id . '"),
                    forceSync: ' . config('editor.forceSync') . ',
                    indentWithTabs: ' . config('editor.indentWithTabs') . ',
                    insertTexts: {
                        horizontalRule: ["", "\n\n-----\n\n"],
                        image: ["![](http://", ")"],
                        link: ["[", "](http://)"],
                        table: ["",
                            "\n\n| Column 1 | Column 2 | Column 3 |\n| -------- | -------- | -------- |\n| Text | Text | Text |\n\n"
                        ],
                    },
                    minHeight: "' . config('editor.minHeight') . '",
                    parsingConfig: {
                        allowAtxHeaderWithoutSpace: ' . config('editor.allowAtxHeaderWithoutSpace') . ',
                        strikethrough: ' . config('editor.strikethrough') . ',
                        underscoresBreakWords: ' . config('editor.underscoresBreakWords') . ',
                    },
                    placeholder: "' . config('editor.placeholder') . '",
                    renderingConfig: {
                        singleLineBreaks: ' . config('editor.singleLineBreaks') . ',
                        codeSyntaxHighlighting: false,
                        markedOptions: {
                           sanitize: true
                        }
                    },
                    spellChecker: ' . config('editor.spellChecker') . ',
                    status : ' . config('editor.status') . ',
                    status: ["autosave", "lines", "words", "cursor"],
                    styleSelectedText: ' . config('editor.styleSelectedText') . ',
                    syncSideBySidePreviewScroll: ' . config('editor.syncSideBySidePreviewScroll') . ',
                    tabSize: ' . config('editor.tabSize') . ',
                    toolbar: '. config('editor.buttons') .',
                    toolbarTips: ' . config('editor.toolbarTips') . ',
                });
                mdeditor.codemirror.setSize("auto", "' . config('editor.maxHeight') . '");
                mdeditor.codemirror.on("optionChange", (item) => {
                    let fullscreen = item.getOption("fullScreen");
                    if (fullscreen)
                        $(".editor-toolbar,.fullscreen,.CodeMirror-fullscreen").css("z-index","9998");
                });
                inlineAttachment.editors.codemirror4.attach(mdeditor.codemirror, {
                    uploadUrl: "' . route('mde-image-upload') . '",
                    uploadFieldName: "mde-image-file",
                    progressText: "![Uploading file...]()",
                    urlText: "\n ![unnamed]({filename}) \n\n",
                    extraParams: {
                        "_token": "' . csrf_token() . '",
                    },
                    onFileUploadResponse: function(xhr) {
                        var result = JSON.parse(xhr.responseText),
                            filename = result[this.settings.jsonFieldName];

                        if (result && filename) {
                            var newValue;
                            if (typeof this.settings.urlText === "function") {
                                newValue = this.settings.urlText.call(this, filename, result);
                            } else {
                                newValue = this.settings.urlText.replace(this.filenameTag, filename);
                            }
                            var text = this.editor.getValue().replace(this.lastValue, newValue);
                            this.editor.setValue(text);
                            this.settings.onFileUploaded.call(this, filename);
                        }
                        return false;
                    }
                });
            });</script>';
    }
}
