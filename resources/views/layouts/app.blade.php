<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js" defer></script>

    <script defer>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('pre code').forEach((codeBlock) => {
                hljs.highlightElement(codeBlock);

                const pre = codeBlock.parentElement;

                const classList = codeBlock.className.split(' ');
                const langClass = classList.find(cls => cls.startsWith('language-'));
                const langName = langClass ? langClass.replace('language-', '').toUpperCase() : 'CODE';

                const wrapper = document.createElement('div');
                wrapper.className =
                    'relative mb-6 rounded-md overflow-hidden border border-gray-300 bg-gray-900';

                pre.parentNode.insertBefore(wrapper, pre);
                wrapper.appendChild(pre);

                const header = document.createElement('div');
                header.className =
                    'flex justify-between items-center text-xs text-white bg-gray-800 px-3 py-2';
                wrapper.insertBefore(header, pre);

                const langLabel = document.createElement('span');
                langLabel.textContent = langName;
                langLabel.className = 'font-semibold tracking-wide';
                header.appendChild(langLabel);

                const copyBtn = document.createElement('button');
                copyBtn.textContent = 'Copy';
                copyBtn.className =
                    'bg-gray-700 text-white px-2 py-1 rounded hover:bg-gray-600 focus:outline-none';
                header.appendChild(copyBtn);

                copyBtn.addEventListener('click', () => {
                    const code = codeBlock.innerText;

                    if (navigator.clipboard && navigator.clipboard.writeText) {
                        navigator.clipboard.writeText(code).then(() => {
                            copyBtn.textContent = 'Copied!';
                            setTimeout(() => copyBtn.textContent = 'Copy', 1500);
                        }).catch(() => {
                            copyBtn.textContent = 'Failed';
                        });
                    } else {
                        const textarea = document.createElement('textarea');
                        textarea.value = code;
                        textarea.style.position = 'fixed';
                        textarea.style.top = 0;
                        textarea.style.left = 0;
                        textarea.style.opacity = '0';
                        document.body.appendChild(textarea);
                        textarea.focus();
                        textarea.select();

                        try {
                            document.execCommand('copy');
                            copyBtn.textContent = 'Copied!';
                        } catch (err) {
                            copyBtn.textContent = 'Failed';
                        }

                        document.body.removeChild(textarea);
                        setTimeout(() => copyBtn.textContent = 'Copy', 1500);
                    }
                });
            });
        });
    </script>

</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>
    </div>
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const textarea = document.getElementById('content');
            if (textarea) {
                textarea.style.display = 'none';

                const editorContainer = document.createElement('div');
                textarea.parentNode.insertBefore(editorContainer, textarea.nextSibling);

                const editor = new toastui.Editor({
                    el: editorContainer,
                    height: '500px',
                    initialEditType: 'markdown',
                    previewStyle: 'vertical',
                    initialValue: textarea.value,
                    hideModeSwitch: true,
                });

                textarea.form.addEventListener('submit', function() {
                    textarea.value = editor.getMarkdown();
                });
            }
            window.addEventListener('pageshow', function(event) {
                if (event.persisted) {
                    window.location.reload();
                }
            });
        });
    </script>

</body>

</html>
