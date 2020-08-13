<x-bc-form:field :label="$label"
                 :error-bag="$errorBag"
                 :readOnly="$readOnly"
                 :disabled="$disabled">

    @if ($prepend ?? null)
        <x-slot name="prepend">{{ $prepend }}</x-slot>
    @endif

    <div x-data="{ isOn: false, value: {{ json_encode($value ?: []) }}, options: {{ json_encode($options) }} }"
         class="relative w-full"
         @click.away="isOn = false"
         {{ $attributes }}
         wire:ignore.self>
                <span class="inline-block w-full rounded-md">
                    <button type="button"
                            @click="isOn = ! isOn"
                            class="cursor-default relative w-full rounded-md border border-gray-300 bg-white pl-3 pr-10 py-2 text-left focus:outline-none focus:shadow-outline-blue focus:border-blue-300 transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        @if ($multiple)
                            <div class="flex flex-wrap space-x-1">
                                <template x-if="value == null || value.length == 0">
                                    <div>-</div>
                                </template>
                                <template x-for="key in value" :key="key">
                                    <div class="rounded-md px-2 text-xs bg-gray-200 text-gray-500" x-text="options[key]">icao</div>
                                </template>
                            </div>
                        @else
                            <span class="block truncate" x-text="options[value] ?? {{ json_encode($placeholder ?: '-') }} "></span>
                        @endif

                        <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="none" stroke="currentColor">
                                <path d="M7 7l3-3 3 3m0 6l-3 3-3-3" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </span>
                    </button>
                </span>

        <div x-show="isOn" x-cloak class="z-10 absolute mt-1 w-full rounded-md bg-white shadow-lg">
            <ul tabindex="-1" role="listbox" aria-labelledby="listbox-label" aria-activedescendant="listbox-item-3" class="max-h-60 rounded-md py-1 text-base leading-6 shadow-xs overflow-auto focus:outline-none sm:text-sm sm:leading-5">
                @foreach ($options as $key => $label)
                    <li class="text-gray-900 cursor-pointer select-none relative py-2 pl-3 pr-9 hover:bg-gray-50"
                        x-on:click="@if ($multiple) value.indexOf('{{ $key }}') >= 0 ? value.splice(value.indexOf({{ json_encode($key) }}), 1) : value.push({{ json_encode($key) }}); @else value = {{ json_encode($key) }};@endif $dispatch('input', value)">
                                <span class="block truncate"
                                      @if ($multiple)
                                      :class="{'font-normal': ! value.indexOf({{ json_encode($key) }}) >= 0, 'font-semibold': value.indexOf({{ json_encode($key) }}) >= 0}"
                                      @else
                                      :class="{'font-normal': value !== {{ json_encode($key) }}, 'font-semibold': value === {{ json_encode($key) }}}"
                                      @endif>
                                    {{ $label }}
                                </span>
                        <span class="absolute inset-y-0 right-0 flex items-center pr-4"
                              @if ($multiple)
                              :class="{'text-white': ! value.indexOf({{ json_encode($key) }}) >= 0, 'text-indigo-600': value.indexOf({{ json_encode($key) }}) >= 0}"
                              @else
                              :class="{'text-white': value !== {{ json_encode($key) }}, 'text-indigo-600': value === {{ json_encode($key) }}}"
                                  @endif>
                                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @if ($append ?? null)
        <x-slot name="append">{{ $append }}</x-slot>
    @endif
</x-bc-form:field>