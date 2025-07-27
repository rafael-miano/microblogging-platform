<button {{ $attributes->merge([
    'type' => 'submit',
    'class' => 'text-sm text-gray-800 hover:text-black focus:outline-none focus:underline transition'
]) }}>
    {{ $slot }}
</button>
