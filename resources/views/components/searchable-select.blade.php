<div class="relative" x-data="{ open: false, search: '', selected: null, selectedName: '' }" x-init="
    @if($selectedValue)
        selected = {{ $selectedValue }};
        selectedName = '{{ $options[$selectedValue] ?? '' }}';
    @endif
">
    @if($label)
        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">{{ $label }}</label>
    @endif
    <div class="relative">
        <input
            type="text"
            x-model="search"
            @focus="open = true"
            @click="open = true"
            @click.away="open = false"
            @keydown.escape="open = false"
            class="block w-full rounded-md border-zinc-300 dark:border-zinc-700 dark:bg-zinc-900 text-sm pr-8"
            placeholder="{{ $placeholder }}"
            :value="selected ? selectedName : search"
        />
        <button
            type="button"
            x-show="selected || search"
            @click="selected = null; selectedName = ''; search = ''; $wire.{{ $wireModel }} = null;"
            class="absolute right-2 top-1/2 -translate-y-1/2 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <div
        x-show="open"
        x-transition
        class="absolute z-10 mt-1 w-full rounded-md bg-white dark:bg-zinc-900 shadow-lg border border-zinc-200 dark:border-zinc-700 max-h-60 overflow-y-auto"
    >
        @forelse($options as $id => $name)
            <div
                x-show="!search || '{{ strtolower($name) }}'.includes(search.toLowerCase())"
                @click="selected = {{ $id }}; selectedName = '{{ addslashes($name) }}'; search = '{{ addslashes($name) }}'; open = false; $wire.{{ $wireModel }} = {{ $id }};"
                class="cursor-pointer px-4 py-2 hover:bg-zinc-100 dark:hover:bg-zinc-800 text-sm"
                :class="selected == {{ $id }} ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400' : 'text-zinc-700 dark:text-zinc-300'"
            >
                {{ $name }}
            </div>
        @empty
            <div class="px-4 py-2 text-sm text-zinc-500">暂无选项</div>
        @endforelse
    </div>
</div>
