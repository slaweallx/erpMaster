@section('meta')
    <meta itemprop="url" content="{{ URL::current() }}">
    <meta property="og:title"
        content="@if (isset($category_id)) {{ \App\Helpers::categoryName($category_id) }} @endif">
    <meta property="og:url" content="{{ URL::current() }}">
@endsection

<div>
    <div class="w-full px-4 mx-auto">
        <div class="mb-4 items-center justify-between bg-white py-2">
            <div class="w-full md:px-4 sm:px-2 flex flex-wrap justify-between">
                <ul class="flex flex-wrap items-center gap-2 py-4 md:py-2 ">
                    <li class="inline-flex">
                        <a href="/" class="text-gray-600 hover:text-blue-500">
                            <svg class="w-5 h-auto fill-current mx-2 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24" fill="#000000">
                                <path d="M0 0h24v24H0V0z" fill="none" />
                                <path
                                    d="M10 19v-5h4v5c0 .55.45 1 1 1h3c.55 0 1-.45 1-1v-7h1.7c.46 0 .68-.57.33-.87L12.67 3.6c-.38-.34-.96-.34-1.34 0l-8.36 7.53c-.34.3-.13.87.33.87H5v7c0 .55.45 1 1 1h3c.55 0 1-.45 1-1z" />
                            </svg>
                        </a>
                        <span class="mx-2 h-auto text-gray-400 font-medium">/</span>
                    </li>
                    <li class="inline-flex">
                        <a href="{{ URL::current() }}" class="text-gray-600 hover:text-blue-500">
                            {{ __('Brands') }}
                        </a>

                        <span class="mx-2 h-auto text-gray-400 font-medium">/</span>
                    </li>
                    <li class="inline-flex">
                        <p class="lg:text-2xl sm:text-xl font-bold text-gray-600">
                            {{ $products->count() }} {{ __('Products') }}
                        </p>
                    </li>
                    <li>
                        <p class="mx-4 space-x-2">
                            @if (isset($category_id))
                                {{ \App\Helpers::categoryName($category_id) }}
                                <button type="button" wire:click="clearFilter('category')"
                                    class="text-red-500">X</button>
                            @endif
                            @if (isset($brand_id))
                                {{ \App\Helpers::brandName($brand_id) }}
                                <button type="button" wire:click="clearFilter('brand')" class="text-red-500">X</button>
                            @endif
                            @if (isset($subcategory_id))
                                {{ \App\Helpers::subcategoryName($subcategory_id) }}
                                <button type="button" wire:click="clearFilter('subcategory')"
                                    class="text-red-500">X</button>
                            @endif
                        </p>
                    </li>
                </ul>

                <div class="w-full sm:w-auto flex justify-center my-2 overflow-x-scroll">
                    <button @click="showSidebar = true" type="button"
                        class="flex lg:hidden items-center justify-center w-12 h-12 text-gray-600 hover:text-green-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke-linecap="round" stroke-linejoin="round"
                            stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <select wire:model.live="perPage" name="perPage"
                        class="lg:px-4 md:px-2 py-2 bg-white text-gray-700 rounded border border-gray-100 text-xs focus:shadow-outline-blue focus:border-beige-500">
                        @foreach ($paginationOptions as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>

                    <select
                        class="lg:px-4 md:px-2 py-2 bg-white text-gray-700 rounded border border-gray-100 text-xs focus:shadow-outline-blue focus:border-beige-500"
                        id="sortBy" wire:model="sorting">
                        <option selected>{{ __('Choose filters') }}</option>
                        @foreach ($sortingOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <div class="flex flex-wrap -mx-3">
            <!-- Mobile sidebar -->
            <div x-show="showSidebar" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full" @click.away="showSidebar = false"
                class="fixed top-0 left-0 bottom-0 bg-white z-50 w-5/6 max-w-sm md:hidden px-6 pt-10 overflow-y-scroll"
                x-cloak>
                <div class="py-4" x-data="{ openCategory: true }">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-xl font-bold font-heading">{{ __('Category') }}</h3>
                        <button @click="openCategory = !openCategory">
                            <i class="fa fa-caret-down"
                                :class="{ 'fa-caret-up': openCategory, 'fa-caret-down': !openCategory }"
                                aria-hidden="true">
                            </i>
                        </button>
                    </div>
                    <ul x-show="openCategory">
                        @foreach ($this->categories as $category)
                            <li class="mb-2">
                                <button type="button" wire:click="filterProducts('category', {{ $category->id }})">
                                    <span class="inline-block px-4 py-2 text-sm font-bold font-heading text-blue-300">
                                        {{ $category->name }} <small>
                                            ({{ $category->products->count() }})
                                        </small>
                                    </span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="border-t border-gray-900 mt-4 py-2"></div>
                <div class="py-4" x-data="{ openSubcategory: true }">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-xl font-bold font-heading">{{ __('Subcategory') }}</h3>
                        <button @click="openSubcategory = !openSubcategory">
                            <i class="fa fa-caret-down"
                                :class="{ 'fa-caret-up': openSubcategory, 'fa-caret-down': !openSubcategory }"
                                aria-hidden="true">
                            </i>
                        </button>
                    </div>
                    <ul x-show="openSubcategory">
                        @foreach ($this->subcategories as $subcategory)
                            <li class="mb-2">
                                <button type="button"
                                    wire:click="filterProducts('subcategory', {{ $subcategory->id }})">
                                    <span class="inline-block px-4 py-2 text-sm font-bold font-heading text-blue-300">
                                        {{ $subcategory->name }} <small>
                                        </small>
                                    </span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    @if (!empty($subcategory_id))
                        <div class="text-right">
                            <button wire:click="clearFilter('subcategory')">{{ __('Clear') }}</button>
                        </div>
                    @endif
                </div>

                <div class="border-t border-gray-900 mt-4 py-2"></div>
                <div class="py-4" x-data="{ openbrands: true }">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-xl font-bold font-heading">{{ __('Brands') }}</h3>
                        <button @click="openbrands = !openbrands">
                            <i class="fa fa-caret-down"
                                :class="{ 'fa-caret-up': openbrands, 'fa-caret-down': !openbrands }" aria-hidden="true">
                            </i>
                        </button>
                    </div>
                    <ul x-show="openbrands" class="flex flex-wrap items-center">
                        {{-- @foreach ($this->brands as $brand)
                            <li class="mx-2 mb-2">
                                <button type="button" wire:click="filterProducts('brand', {{ $brand->id }})">
                                    <span class="inline-block px-4 py-2 text-sm font-bold font-heading text-blue-300">
                                        {{ $brand->name }} <small> ({{ $brand->products->count() }})</small>
                                    </span>
                                </button>
                            </li>
                        @endforeach --}}
                    </ul>
                    @if (!empty($brand_id))
                        <div class="text-right">
                            <button wire:click="clearFilter('brand')">{{ __('Clear') }}</button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="hidden lg:block w-1/4 px-3">
                <div class="mb-6 p-4 bg-white" x-data="{ openCategory: true }">
                    <div class="flex justify-between mb-8">
                        <h3 class="text-xl font-bold font-heading">{{ __('Category') }}</h3>
                        <button @click="openCategory = !openCategory">
                            <i class="fa fa-caret-down"
                                :class="{ 'fa-caret-up': openCategory, 'fa-caret-down': !openCategory }"
                                aria-hidden="true">
                            </i>
                        </button>
                    </div>
                    <ul x-show="openCategory">
                        @foreach ($this->categories as $category)
                            <li class="mb-2">
                                <button type="button" wire:click="filterProducts('category', {{ $category->id }})">
                                    <span class="inline-block px-4 py-2 text-sm font-bold font-heading text-blue-300">
                                        {{ $category->name }} <small>
                                            ({{ $category->products->count() }})
                                        </small>
                                    </span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="mb-6 p-4 bg-white" x-data="{ openSubcategory: true }">
                    <div class="flex justify-between mb-8">
                        <h3 class="text-xl font-bold font-heading">{{ __('Subcategory') }}</h3>
                        <button @click="openSubcategory = !openSubcategory">
                            <i class="fa fa-caret-down"
                                :class="{ 'fa-caret-up': openSubcategory, 'fa-caret-down': !openSubcategory }"
                                aria-hidden="true">
                            </i>
                        </button>
                    </div>
                    <ul x-show="openSubcategory">
                        @foreach ($this->subcategories as $subcategory)
                            <li class="mb-2">
                                <button type="button"
                                    wire:click="filterProducts('subcategory', {{ $subcategory->id }})">
                                    <span class="inline-block px-4 py-2 text-sm font-bold font-heading text-blue-300">
                                        {{ $subcategory->name }} <small>
                                        </small>
                                    </span>
                                </button>
                            </li>
                        @endforeach
                    </ul>
                    @if (!empty($subcategory_id))
                        <div class="text-right">
                            <button wire:click="clearFilter('subcategory')">{{ __('Clear') }}</button>
                        </div>
                    @endif
                </div>

                <div class="mb-6 p-4 bg-white" x-data="{ openbrands: true }">
                    <div class="flex justify-between mb-8">
                        <h3 class="text-xl font-bold font-heading">{{ __('Brands') }}</h3>
                        <button @click="openbrands = !openbrands">
                            <i class="fa fa-caret-down"
                                :class="{ 'fa-caret-up': openbrands, 'fa-caret-down': !openbrands }"
                                aria-hidden="true">
                            </i>
                        </button>
                    </div>
                    <ul x-show="openbrands" class="flex flex-wrap items-center">
                        {{-- @foreach ($this->brands as $brand)
                            <li class="mx-2 mb-2">
                                <button type="button" wire:click="filterProducts('brand', {{ $brand->id }})">
                                    <span class="inline-block px-4 py-2 text-sm font-bold font-heading text-blue-300">
                                        {{ $brand->name }} <small> ({{ $brand->products->count() }})</small>
                                    </span>
                                </button>
                            </li>
                        @endforeach --}}
                    </ul>
                    @if (!empty($brand_id))
                        <div class="text-right">
                            <button wire:click="clearFilter('brand')">{{ __('Clear') }}</button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="w-full lg:w-3/4 px-4" x-data="{ loading: false }">
                <div class="grid gap-6 lg:grid-cols-4 md:grid-cols-3 sm:grid-cols-2 
 xs:grid-cols-2 mb-10"
                    id="product-container">
                    @forelse ($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="w-full">
                            <h3 class="text-3xl font-bold font-heading text-blue-900">
                                {{ __('No products found') }}
                            </h3>
                        </div>
                    @endforelse
                </div>
                <div class="flex justify-center mt-10" x-show="!loading && '{{ $products->hasMorePages() }}'">
                    <div x-intersect="() => { $wire.loadMore(() => loading = false) }"
                        x-transition:enter="transition ease-out duration-1000"
                        x-transition:enter-start="opacity-0 transform translate-y-10"
                        x-transition:enter-end="opacity-100 transform translate-y-0">
                        <div class="flex items-center justify-center text-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-500" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647zM20 12a8 8 0 01-8 8v4c4.627 0 10-5.373 10-12h-4zm-2-5.291A7.962 7.962 0 0120 12h4c0-3.042-1.135-5.824-3-7.938l-3 2.647z">
                                </path>
                            </svg>
                            <span>{{ __('Loading...') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
