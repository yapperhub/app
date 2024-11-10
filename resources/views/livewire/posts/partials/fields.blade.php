<div class="flex">
    <div class="w-1/2 space-y-4">
        <div class="space-y-1">
            <x-input-label for="title" required="true">Title</x-input-label>
            <x-text-input id="title" name="form.title" type="text" wire:model="form.title" class="w-full" />
        </div>

        <div class="space-y-1">
            <x-input-label for="excerpt" required="true">Excerpt / Meta Description</x-input-label>
            <x-text-area id="excerpt" name="form.excerpt" type="text" wire:model="form.excerpt" class="w-full" />
        </div>

        <div class="space-y-1">
            <x-input-label for="featured-image" required="{{ false }}">Featured Image</x-input-label>
            <x-text-input
                id="featured-image"
                name="form.featured_image"
                type="url"
                wire:model="form.featured_image"
                class="w-full"
            />
        </div>
    </div>

    <div class="ml-12">
        <x-h2-heading>Editor Basics</x-h2-heading>
        <div class="mt-6 space-y-4">
            <p>Use Markdown to format your post. Here are some basic examples:</p>
            <ul class="list-inside list-disc">
                <li>**bold text**</li>
                <li>*italic text*</li>
                <li>[link text](https://example.com)</li>
                <li>![image alt text](https://example.com/image.jpg)</li>
                <li># Heading 1</li>
                <li>## Heading 2 and so on</li>
            </ul>
            <p>
                For more advanced formatting, check out the
                <a href="https://www.markdownguide.org/cheat-sheet" target="_blank" class="text-blue-500">
                    Markdown Guide
                </a>
                .
            </p>
        </div>
    </div>
</div>
<div class="mt-6 space-y-1">
    <x-input-label for="content" required="{{ true }}">content</x-input-label>
    <x-mary-markdown wire:model="form.content" label="" />
</div>
