<div
    {{ $attributes->class([
    'flex items-center py-0 rounded-md border-gray-300 px-2 placeholder-gray-500 text-sm bg-white'
    ]) }}>
    <label :for="$id" class="block text-sm font-medium text-gray-700">
    </label>
    <input @class([
        'w-full border-none bg-transparent py-1.5'
        ])
        {{ $attributes->except('class')->merge(['type' => 'text']) }}>
</div>