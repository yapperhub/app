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

        {{--<div class="space-y-1">
            <x-input-label for="featured-image" required="{{ false }}">Featured Image</x-input-label>
            <x-text-input
                id="featured-image"
                name="form.featured_image"
                type="url"
                wire:model="form.featured_image"
                class="w-full"
            />
        </div>--}}

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
            <x-mary-checkbox
                label="Publish Post"
                wire:model="form.isPublished"
                hint="Publish the post on the platform."
            />
        </div>
    </div>
    <div class="ml-12 w-1/2">
        {{--<x-h2-heading>Editor Basics</x-h2-heading>
        <div class="flex flex-row gap-5">
            <div class="w-7/12 space-y-4">
                <div class="mt-6 space-y-4">
                    <p>Use Markdown to format your post.</p>
                    <p>
                        The tool bar above the editor can also help you format your post but is not limited to the
                        available options.
                    </p>
                    <p>Here are some basic examples on the side:</p>
                    <p>
                        For more advanced formatting, check out the
                        <a href="https://www.markdownguide.org/cheat-sheet" target="_blank" class="text-blue-500">
                            Markdown Guide
                        </a>
                        .
                    </p>
                </div>
            </div>
            <div class="">
                <div class="mt-6 space-y-4">
                    <ul class="list-inside list-disc">
                        <li>**bold text**</li>
                        <li>*italic text*</li>
                        <li>[link text](https://example.com)</li>
                        <li>![image alt text](https://example.com/image.jpg)</li>
                        <li># Heading 1 and ## Heading 2 and so on</li>
                    </ul>
                </div>
            </div>
        </div>
        <hr class="mt-3 mb-3" />--}}

        <x-input-label for="featured-image" required="{{ false }}">Featured Image</x-input-label>
        <x-mary-file wire:model="form.featured_image" accept="image/png, image/jpeg" class="mt-2">
            <img src="{{ $user->avatar ?? '/img/fimg.jpg' }}" class="max-w-xl rounded-lg" alt="featured image." />
        </x-mary-file>
    </div>
</div>
<div class="mt-6 space-y-1">
    <x-input-label for="content" required="{{ true }}">Content</x-input-label>
    <x-mary-markdown wire:model="form.content" label="" />
</div>
