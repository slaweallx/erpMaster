<div>
    @section('title', __('Sections'))

    <x-theme.breadcrumb :title="__('Sections List')" :parent="route('admin.sections.index')" :parentName="__('Sections List')">

        <x-button primary href="{{ route('admin.section.settings') }}">
            {{ __('Section Settings') }}
        </x-button>
        <x-button primary type="button" wire:click="dispatchTo('admin.section.create', 'createModal')">
            {{ __('Create Section') }}
        </x-button>
        <x-button primary type="button" wire:click="dispatchTo('admin.section.create', 'createModal')">
            {{ __('Create Section') }}
        </x-button>

    </x-theme.breadcrumb>
    <div class="flex flex-wrap justify-center">
        <div class="lg:w-1/2 md:w-1/2 sm:w-full flex flex-wrap gap-6 w-full">
            <select wire:model.live="perPage"
                class="w-auto shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block sm:text-sm border-gray-300 rounded-md focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                @foreach ($paginationOptions as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
            @if ($selected)
                <x-button danger type="button" wire:click="deleteSelected" class="ml-3">
                    <i class="fas fa-trash"></i>
                </x-button>
            @endif
            @if ($this->selectedCount)
                <p class="text-sm leading-5">
                    <span class="font-medium">
                        {{ $this->selectedCount }}
                    </span>
                    {{ __('Entries selected') }}
                </p>
                <p wire:click="resetSelected" wire:loading.attr="disabled"
                    class="text-sm leading-5 font-medium text-red-500 cursor-pointer ">
                    {{ __('Clear Selected') }}
                </p>
            @endif
        </div>
        <div class="lg:w-1/2 md:w-1/2 sm:w-full ">
            <x-input wire:model.live="search" placeholder="{{ __('Search') }}" autofocus />
        </div>
    </div>

    <x-table>
        <x-slot name="thead">
            <x-table.th>#</x-table.th>
            <x-table.th sortable wire:click="sortingBy('page')" field="page" :direction="$sorts['page'] ?? null">
                {{ __('Page') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('title')" field="title" :direction="$sorts['title'] ?? null">
                {{ __('Title') }}
            </x-table.th>
            <x-table.th sortable wire:click="sortingBy('status')" field="status" :direction="$sorts['status'] ?? null">
                {{ __('Status') }}
            </x-table.th>
            <x-table.th>
                {{ __('Actions') }}
            </x-table.th>
        </x-slot>
        <x-table.tbody>
            @forelse($sections as $section)
                <x-table.tr wire:loading.class.delay="opacity-50" wire:key="row-{{ $section->id }}">
                    <x-table.td>
                        <input type="checkbox" value="{{ $section->id }}" wire:model="selected">
                    </x-table.td>
                    <x-table.td>
                        {{ $section->page }}
                    </x-table.td>
                    <x-table.td>
                        {{ $section->title }}
                    </x-table.td>

                    <x-table.td>
                        <livewire:utils.toggle-button :model="$section" field="status" key="{{ $section->id }}"
                            lazy />
                    </x-table.td>
                    <x-table.td>
                        <div class="inline-flex space-x-2">
                            <x-button info type="button"
                                wire:click="$dispatch('editModal', { id : {{ $section->id }} })"
                                wire:loading.attr="disabled">
                                <i class="fas fa-edit"></i>
                            </x-button>
                            <x-button danger type="button" wire:click="deleteModal({{ $section->id }})"
                                wire:loading.attr="disabled">
                                <i class="fas fa-trash-alt"></i>
                            </x-button>
                            <x-button warning type="button" wire:click="clone({{ $section->id }})"
                                wire:loading.attr="disabled">
                                {{ __('Clone') }}
                            </x-button>
                        </div>
                    </x-table.td>
                </x-table.tr>
            @empty
                <x-table.tr>
                    <x-table.td colspan="10" class="text-center">
                        {{ __('No entries found.') }}
                    </x-table.td>
                </x-table.tr>
            @endforelse
        </x-table.tbody>
    </x-table>

    <div class="pt-3">
        {{ $sections->links() }}
    </div>

    <livewire:admin.section.edit :section="$section" />

    <livewire:admin.section.create lazy />

    {{-- <livewire:admin.section.template lazy /> --}}

</div>
