<div>
    @section('title', __('Create Quotation'))

    <x-theme.breadcrumb :title="__('Create Quotation')" :parent="route('admin.quotations.index')" :parentName="__('Quotations List')" :children="URL::Current()" :childrenName="__('Create Quotation')">

    </x-theme.breadcrumb>

    <div class="flex flex-wrap">

        <div class="lg:w-1/2 sm:w-full h-full">
            <livewire:search-product />
        </div>

        <div class="lg:w-1/2 sm:w-full h-full">
            <x-validation-errors class="mb-4" :errors="$errors" />

            <form wire:submit="store">
                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <label for="customer_id">{{ __('Customer') }} <span class="text-red-500">*</span></label>
                        <x-select-list :options="$this->customers" name="customer_id" id="customer_id"
                            wire:model.live="customer_id" />
                        <x-input-error :messages="$errors->get('customer_id')" class="mt-2" />

                    </div>
                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <x-label for="warehouse" :value="__('Warehouse')" required />
                        <select
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                            required id="warehouse_id" name="warehouse_id" wire:model.live="warehouse_id">
                            <option value="">{{ __('Select Warehouse') }}</option>
                            @foreach ($this->warehouses as $warehouse)
                                <option value="{{ $warehouse->id }}">
                                    {{ $warehouse->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('warehouse_id')" class="mt-2" />
                    </div>

                    <div class="w-full md:w-1/2 px-3 mb-4 md:mb-0">
                        <x-label for="date" :value="__('Date')" required />
                        <input type="date" name="date" required wire:model.live="date"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1">
                        <x-input-error :messages="$errors->get('date')" class="mt-2" />
                    </div>

                </div>

                <livewire:product-cart :cartInstance="'quotation'" />

                <div class="flex flex-wrap -mx-2 mb-3">
                    <div class="w-full md:w-1/3 px-2 mb-2">
                        <div class="mb-4">
                            <x-label for="status" :value="__('Status')" required />
                            <select wire:model="status"
                                class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"
                                name="status" id="status" required>
                                <option value="">{{ __('Select Status') }}</option>
                                @foreach (\App\Enums\QuotationStatus::values() as $key => $value)
                                    <option value="{{ $key }}">
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="w-full md:w-1/9 px-3 mb-4 md:mb-0">
                        <label for="note">{{ __('Note (If Needed)') }}</label>
                        <textarea name="note" id="note" rows="5" wire:model="note"
                            class="block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-md mt-1"></textarea>
                    </div>
                </div>



                <div class="w-full mt-3">
                    <x-button type="submit" primary class="w-full text-center">
                        {{ __('Create Quotation') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</div>
