<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix/dist/trix.min.css" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/trix/dist/trix.umd.min.js" crossorigin="anonymous"></script>
    <script>
        Trix.config.attachments.preview.caption = {
            name: false,
            size: false
        };
    </script>
</head>

<body>
    <form action="{{ url('store') }}" method="post">
        @csrf
        <input type="hidden" name="content" id="x">
        <trix-editor input="x" class="trix-content" autofocus></trix-editor>
        <button>Submit</button>
    </form>
    <script>
        (function() {
            const HOST = window.location.origin;

            addEventListener("trix-attachment-add", function(event) {
                if (event.attachment.file) {
                    uploadFileAttachment(event.attachment);
                }
            });

            addEventListener("trix-attachment-remove", function(event) {
                console.log(event.attachment);
                if (event.attachment.file) {
                    removeFileAttachment(event.attachment);
                }
            });

            function removeFileAttachment(attachment) {
                xhr.open("POST", `${window.location.origin}/remove-file`, true);
            }

            function uploadFileAttachment(attachment) {
                uploadFile(attachment.file, setProgress, setAttributes);

                function setProgress(progress) {
                    attachment.setUploadProgress(progress);
                }

                function setAttributes(attributes) {
                    attachment.setAttributes(attributes);
                }
            }

            function uploadFile(file, progressCallback, successCallback) {
                const key = createStorageKey(file);
                const formData = createFormData(key, file);
                const xhr = new XMLHttpRequest();

                xhr.open("POST", `${window.location.origin}/upload-file`, true);
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                xhr.upload.addEventListener("progress", function(event) {
                    const progress = event.loaded / event.total * 100;
                    progressCallback(progress);
                });

                xhr.addEventListener("load", function(event) {
                    if (xhr.status == 200) {
                        const jsonResponse = JSON.parse(xhr.responseText);
                        const pathUrl = jsonResponse.url;
                        let attributes = {
                            url: HOST + pathUrl,
                            href: HOST + pathUrl + "?content-disposition=attachment"
                        }
                        console.log(attributes);
                        successCallback(attributes);
                    }
                });
                xhr.send(formData);
            }

            function createStorageKey(file) {
                return ["/storage", "uploads", file.name].join("/");
            }

            function createFormData(key, file) {
                const data = new FormData();
                data.append("key", key);
                data.append("Content-Type", file.type);
                data.append("file", file);
                return data;
            }
        })();
    </script>
</body>

</html>
