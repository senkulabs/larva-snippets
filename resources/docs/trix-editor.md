<details class="my-4">
    <summary>Let me see the code 👀</summary>
    
```php tab=Route filename=routes/web.php
<?php

Volt::route('/trix-editor', 'trix-editor');
```

```php tab=Component filename=resources/views/livewire/trix-editor.blade.php
<?php

use Livewire\Attributes\Title;
use Livewire\Volt\Component;

new
#[Title('Trix Editor - Larva Snippets')]
class extends Component {
    public $content = '';

    public function with(): array
    {
        return [
            'md_content' => markdown_convert(resource_path('docs/trix-editor.md')),
        ];
    }

    public function submit()
    {
        // TODO: Add validation here
    }

    public function clear()
    {
        $this->content = '';
    }
}; ?>

@assets
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/trix/dist/trix.min.css" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/trix/dist/trix.umd.min.js" crossorigin="anonymous"></script>
@endassets

<div
    x-data="{
        content: $wire.entangle('content'),
        upload(event) {
            const data = new FormData();
            data.append('file', event.attachment.file);

            fetch('/upload-file', {
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                },
                method: 'POST',
                credentials: 'same-origin',
                body: data
            })
            .then(response => response.json())
            .then(data => {
                event.attachment.setAttributes({
                    url: data.image_url
                });
            });
        }
    }">
    <h2 class="text-xl mb-4">Text Area with Trix Editor</h2>
    {!! $md_content !!}
    <form class="mb-4" wire:submit="submit">
        <div wire:ignore
            x-on:trix-change="content = $event.target.value"
            x-on:trix-initialize="$refs.text.editor.loadHTML(content)">

            <input type="hidden" id="x" x-model="content">

            <trix-editor
            x-on:trix-file-accept="event.preventDefault()"
            x-on:trix-attachment-add="upload"
            x-ref="text"
            input="x" class="trix-content"></trix-editor>
        </div>
        <button class="bg-blue-500 text-white p-2 rounded my-4">Submit</button>
        <button type="button" x-on:click="$wire.clear(); $refs.text.editor.loadHTML('');" class="bg-gray-200 p-2 rounded my-4">Clear</button>
        {!! $content !!}
    </form>
</div>
```
</details>
