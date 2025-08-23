<div class="select-multiple-container relative">
    <label for="{{ $name }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $label }}</label>
    <select
        class="select-multiple absolute top-0 left-0 w-full h-full opacity-0"
        name="{{ $name }}[]"
        multiple="multiple"
        id="{{ $name }}"
    >
        @foreach ($options as $option)
            <option
                value="{{ $option['value'] }}"
                @if(in_array($option['value'], $value)) selected @endif
            >{{ $option['label'] }}</option>
        @endforeach
    </select>
</div>
