<section class="space-y-4">
    <header>
        <h2 class="text-base font-medium text-gray-800">
            {{ __('Delete Account') }}
        </h2>
        <p class="mt-1 text-xs text-gray-500">
            {{ __('All data will be permanently deleted. Download anything you want to keep first.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="px-3 py-1 text-sm"
    >
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-4 space-y-4">
            @csrf
            @method('delete')

            <h2 class="text-base font-medium text-gray-800">
                {{ __('Confirm Account Deletion') }}
            </h2>

            <p class="text-xs text-gray-500">
                {{ __('This action cannot be undone. Enter your password to confirm.') }}
            </p>

            <div>
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full text-sm"
                    placeholder="{{ __('Password') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-1 text-xs" />
            </div>

            <div class="flex justify-end space-x-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="px-3 py-1 text-sm">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="px-3 py-1 text-sm">
                    {{ __('Delete') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>