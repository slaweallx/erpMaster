<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Subcategory;

use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Gate;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use App\Models\Subcategory;
use App\Models\Category;
use App\Models\Language;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;

class Edit extends Component
{
    use LivewireAlert;
    use WithFileUploads;

    public $editModal = false;

    public $subcategory;

    #[Rule('required', message: 'Please provide a name')]
    #[Rule('min:3', message: 'This name is too short')]
    public string $name;

    #[Rule('nullable')]
    public $slug;

    #[Rule('nullable')]
    public $category_id;

    #[Rule('nullable')]
    public $language_id;

    public $image;

    #[On('editModal')]
    public function editModal($id)
    {
        abort_if(Gate::denies('subcategory update'), 403);

        $this->resetErrorBag();

        $this->resetValidation();

        $this->subcategory = Subcategory::findOrFail($id);

        $this->name = $this->subcategory->name;
        $this->slug = $this->subcategory->slug;
        $this->category_id = $this->subcategory->category_id;
        $this->language_id = $this->subcategory->language_id;
        $this->image = $this->subcategory->image;

        $this->editModal = true;
    }

    public function update()
    {
        $this->validate();

        if ($this->slug !== $this->subcategory->slug) {
            $this->slug = Str::slug($this->name);
        }

        if ($this->image) {
            $imageName = Str::slug($this->subcategory->name).'-'.$this->image->extension();

            $this->image->storeAs('subcategories', $imageName);

            $this->subcategory->image = $imageName;
        }

        $this->subcategory->update($this->all());

        $this->alert('success', __('Subcategory updated successfully'));

        $this->dispatch('refreshIndex')->to(Index::class);

        $this->reset(['name', 'slug', 'category_id', 'language_id', 'image']);

        $this->editModal = false;
    }

    #[Computed]
    public function categories()
    {
        return Category::select('name', 'id')->get();
    }

    #[Computed]
    public function languages()
    {
        return Language::select('name', 'id')->get();
    }

    public function render(): View
    {
        return view('livewire.admin.subcategory.edit');
    }
}
