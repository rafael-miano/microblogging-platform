<section class="space-y-4" x-data="{
    formData: {
        username: '{{ old('username', $user->username) }}',
        name: '{{ old('name', $user->name) }}',
        email: '{{ old('email', $user->email) }}',
        bio: '{{ old('bio', $user->bio) }}',
        image: null
    },
    errors: {},
    success: false,
    isLoading: false,
    emailVerification: {
        needsVerification: {{ $user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail() ? 'true' : 'false' }},
        verificationSent: false
    },

    async submit() {
        this.isLoading = true;
        this.errors = {};
        this.success = false;

        try {
            const formData = new FormData();
            formData.append('username', this.formData.username);
            formData.append('name', this.formData.name);
            formData.append('email', this.formData.email);
            formData.append('bio', this.formData.bio ?? '');

            if (this.formData.image instanceof File) {
                formData.append('image', this.formData.image);
            }

            const response = await fetch('{{ route('profile.update') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: (() => {
                    formData.append('_method', 'PATCH');
                    return formData;
                })()
            });

            const data = await response.json();

            if (response.ok) {
                this.success = true;
                setTimeout(() => this.success = false, 2000);

                if (this.formData.email !== '{{ $user->email }}') {
                    this.emailVerification.needsVerification = true;
                    this.emailVerification.verificationSent = false;
                }

                if (data.avatar_url) {
                    const avatar = document.getElementById('avatar-preview');
                    if (avatar) avatar.src = data.avatar_url;
                }
            } else {
                this.errors = data.errors || {};
            }
        } catch (error) {
            console.error('Error:', error);
            this.errors = { general: ['An unexpected error occurred'] };
        } finally {
            this.isLoading = false;
        }
    },

    async resendVerification() {
        try {
            const response = await fetch('{{ route('verification.send') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                this.emailVerification.verificationSent = true;
                setTimeout(() => this.emailVerification.verificationSent = false, 3000);
            }
        } catch (error) {
            console.error('Error resending verification:', error);
        }
    },

    handleImageChange(event) {
        this.formData.image = event.target.files[0];
        if (this.formData.image) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const avatar = document.getElementById('avatar-preview');
                if (avatar) avatar.src = e.target.result;
            };
            reader.readAsDataURL(this.formData.image);
        }
    }
}">
    <header>
        <h2 class="text-base font-medium text-gray-800">
            {{ __('Profile Information') }}
        </h2>
        <p class="mt-1 text-xs text-gray-500">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form @submit.prevent="submit" enctype="multipart/form-data" class="space-y-4">

        <div x-data="{
            dragging: false,
            handleDrop(event) {
                this.dragging = false;
                const file = event.dataTransfer.files[0];
                if (file && file.type.startsWith('image/')) {
                    $refs.fileInput.files = event.dataTransfer.files;
                    formData.image = file;
        
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const avatar = document.getElementById('avatar-preview');
                        if (avatar) avatar.src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                } else {
                    errors.image = ['Invalid file type'];
                }
            }
        }" class="flex items-center space-x-4" @dragover.prevent="dragging = true"
            @dragleave.prevent="dragging = false" @drop.prevent="handleDrop($event)">
            <div :class="{ 'border-blue-500 bg-blue-50': dragging }"
                class="w-24 sm:w-20 aspect-square border-2 border-dashed border-gray-300 rounded-full overflow-hidden bg-gray-50 cursor-pointer transition"
                @click="$refs.fileInput.click()">
                <img id="avatar-preview" src="{{ $avatarUrl }}"
                    onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $avatarInitials }}&length=2&background=gray&color=fff&rounded=true';"
                    alt="{{ Auth::user()->username }}" class="w-full h-full object-cover rounded-full" />
            </div>


            <div>
                <x-input-label for="image" :value="__('Choose or Drag & Drop')" class="text-xs" />
                <input x-ref="fileInput" id="image" type="file" name="image" accept="image/*"
                    class="block mt-1 w-full text-xs" @change="handleImageChange" hidden />
                <template x-if="errors.image">
                    <p x-text="errors.image[0]" class="mt-1 text-xs text-red-500"></p>
                </template>
            </div>
        </div>

        <!-- Other Form Fields -->
        <div>
            <x-input-label for="username" :value="__('Username')" class="text-xs" />
            <x-text-input id="username" x-model="formData.username" type="text" class="mt-1 block w-full text-sm"
                required autocomplete="username" />
            <template x-if="errors.username">
                <p x-text="errors.username[0]" class="mt-1 text-xs text-red-500"></p>
            </template>
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" class="text-xs" />
            <x-text-input id="name" x-model="formData.name" type="text" class="mt-1 block w-full text-sm"
                required autocomplete="name" />
            <template x-if="errors.name">
                <p x-text="errors.name[0]" class="mt-1 text-xs text-red-500"></p>
            </template>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-xs" />
            <x-text-input id="email" x-model="formData.email" type="email" class="mt-1 block w-full text-sm"
                required autocomplete="email" />
            <template x-if="errors.email">
                <p x-text="errors.email[0]" class="mt-1 text-xs text-red-500"></p>
            </template>

            <div x-show="emailVerification.needsVerification" class="mt-2 text-xs text-gray-600">
                <p>{{ __('Your email address is unverified.') }}</p>
                <button type="button" @click="resendVerification" class="underline hover:text-gray-800"
                    :disabled="emailVerification.verificationSent">
                    <span
                        x-text="emailVerification.verificationSent ? '{{ __('Verification sent!') }}' : '{{ __('Resend verification email') }}'"></span>
                </button>
            </div>
        </div>

        <div>
            <x-input-label for="bio" :value="__('Bio')" class="text-xs" />
            <textarea id="bio" x-model="formData.bio"
                class="block mt-1 w-full text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                name="bio" rows="3"></textarea>
            <template x-if="errors.bio">
                <p x-text="errors.bio[0]" class="mt-1 text-xs text-red-500"></p>
            </template>
        </div>

        <div class="flex items-center space-x-3">
            <x-primary-button type="submit"
                class="inline-flex items-center justify-center w-60 px-3 py-2 rounded-md bg-[#1875FF] text-white text-xs font-medium shadow-[0px_14px_56px_-11px_#1875FF] transition-all duration-300
    hover:bg-[#1669e8] hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#1875FF] disabled:opacity-50"
                x-bind:disabled="isLoading">

                <span x-show="!isLoading" x-cloak>{{ __('SAVE') }}</span>

                <span x-show="isLoading" x-cloak class="inline-flex items-center">
                    <svg class="animate-spin -ml-1 mr-1 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4" />
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2
                5.291A7.962 7.962 0 014 12H0c0
                3.042 1.135 5.824 3 7.938l3-2.647z" />
                    </svg>
                    {{ __('Saving...') }}
                </span>
            </x-primary-button>

            <span x-show="success" x-transition class="text-xs text-green-500">
                {{ __('Saved') }}
            </span>
        </div>
    </form>
</section>
