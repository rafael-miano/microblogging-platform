<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-stretch"> <!-- Added items-stretch -->
            <!-- Left Column - Profile -->
            <div class="bg-white p-6 rounded-lg shadow-sm flex flex-col"> <!-- Added flex flex-col -->
                @include('profile.partials.update-profile-information-form')
            </div>

            <!-- Right Column - Password and Delete -->
            <div class="space-y-6 flex flex-col"> <!-- Added flex flex-col -->
                <div class="bg-white p-6 rounded-lg shadow-sm flex-grow"> <!-- Added flex-grow -->
                    @include('profile.partials.update-password-form')
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm flex-grow"> <!-- Added flex-grow -->
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>