<section class="space-y-3" x-data="{
    formData: {
        current_password: '',
        password: '',
        password_confirmation: ''
    },
    errors: {},
    success: false,
    isLoading: false,

    async submit() {
        this.isLoading = true;
        this.errors = {};
        this.success = false;

        try {
            const response = await fetch('{{ route('password.update') }}', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(this.formData)
            });

            const data = await response.json();

            if (response.ok) {
                this.success = true;
                this.formData = {
                    current_password: '',
                    password: '',
                    password_confirmation: ''
                };
                setTimeout(() => this.success = false, 2000);
            } else {
                this.errors = data.errors || {};
            }
        } catch (error) {
            console.error('Error:', error);
            this.errors = { general: ['An unexpected error occurred'] };
        } finally {
            this.isLoading = false;
        }
    }
}">
    <header>
        <h2 class="text-base font-medium text-gray-800">
            {{ __('Update Password') }}
        </h2>
        <p class="mt-1 text-xs text-gray-500">
            {{ __('Use a long, random password for security.') }}
        </p>
    </header>

    <form @submit.prevent="submit" class="space-y-3">
        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-xs" />
            <x-text-input id="update_password_current_password" x-model="formData.current_password" type="password"
                class="mt-1 block w-full text-sm" autocomplete="current-password" />
            <template x-if="errors.current_password">
                <p x-text="errors.current_password[0]" class="mt-1 text-xs text-red-500"></p>
            </template>
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" class="text-xs" />
            <x-text-input id="update_password_password" x-model="formData.password" type="password"
                class="mt-1 block w-full text-sm" autocomplete="new-password" />
            <template x-if="errors.password">
                <p x-text="errors.password[0]" class="mt-1 text-xs text-red-500"></p>
            </template>
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-xs" />
            <x-text-input id="update_password_password_confirmation" x-model="formData.password_confirmation"
                type="password" class="mt-1 block w-full text-sm" autocomplete="new-password" />
            <template x-if="errors.password_confirmation">
                <p x-text="errors.password_confirmation[0]" class="mt-1 text-xs text-red-500"></p>
            </template>
        </div>

        <div class="flex items-center space-x-3">
            <x-primary-button type="submit"
                class="inline-flex items-center justify-center w-60 px-3 py-2 rounded-md bg-[#1875FF] text-white text-xs font-medium shadow-[0px_10px_40px_-10px_#1875FF] transition-all duration-300
    hover:bg-[#1669e8] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1875FF] disabled:opacity-50"
                x-bind:disabled="isLoading">

                <span x-show="!isLoading" x-cloak>{{ __('UPDATE') }}</span>

                <span x-show="isLoading" x-cloak class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2
                5.291A7.962 7.962 0 014 12H0c0
                3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    {{ __('Updating...') }}
                </span>
            </x-primary-button>
            <span x-show="success" x-transition class="text-xs text-green-500">
                {{ __('Password updated') }}
            </span>
        </div>
    </form>
</section>
