<button
    {{ $attributes->merge([
        'type' => 'submit',
        'class' =>
            'flex-1 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-xl hover:bg-red-700 transition-colors cursor-pointer',
    ]) }}>
    {{ $slot }}
</button>
