<div class="flex">
    <div class="w-1/2 space-y-4">
        <div class="space-y-1">
            <x-input-label for="title" required="true">Title</x-input-label>
            <x-text-input id="title" name="form.title" type="text" wire:model="form.title" class="w-full" />
        </div>
        <div class="space-y-1">
            <x-input-label for="canonical-url" required="{{ false }}">Canonical Url</x-input-label>
            <x-text-input
                id="canonical-url"
                name="form.canonical_url"
                type="url"
                wire:model="form.canonical_url"
                class="w-full"
            />
        </div>
        <div class="space-y-1">
            <x-input-label for="tags" required="{{ false }}">Tags</x-input-label>
            <x-mary-tags
                wire:model="form.tags"
                hint="Hit enter to create a new tag, tyr to keep it short and simple and not more than 3 tags per post."
                id="tags"
                class="h-2 rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500"
            />
        </div>
    </div>
    <div class="ml-12 w-1/2">
        <x-input-label for="image" required="{{ false }}">Featured Image</x-input-label>
        <x-mary-file wire:model="form.image" accept="image/png, image/jpeg" class="mt-2">
            <img src="{{ $this->image_url ?? '/img/fimg.jpg' }}" class="max-h-60 rounded-lg" alt="featured image" />
        </x-mary-file>
    </div>
</div>
<div class="mt-6 space-y-1">
    <x-input-label for="excerpt" required="true">Excerpt / Meta Description</x-input-label>
    <x-text-area id="excerpt" name="form.excerpt" type="text" wire:model="form.excerpt" class="w-full" />
</div>
<div class="mt-6 space-y-1">
    <x-input-label for="content" required="{{ true }}">Content</x-input-label>
    <x-mary-markdown wire:model="form.content" label="" />
</div>
