@props(['user', 'size'=> 'h-12 w-12'])

{{-- @if($user->image)
<img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}"
    class="rounded-full {{ $size }}">
@else
<img src="https://e7.pngegg.com/pngimages/1000/665/png-clipart-computer-icons-profile-s-free-angle-sphere-thumbnail.png"
    alt="Avatar" class="rounded-full {{ $size }}">
@endif --}}

<img src="{{ $avatarUrl }}"
     onerror="this.onerror=null;this.src='https://ui-avatars.com/api/?name={{ $avatarInitials }}&length=2&background=gray&color=fff&rounded=true';"
     alt="{{ Auth::user()->username }}"
     class="object-cover rounded-full" />
