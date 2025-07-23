@props(['user', 'size'=> 'h-12 w-12'])

@if($user->image)
<img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}"
    class="rounded-full {{ $size }}">
@else
<img src="https://e7.pngegg.com/pngimages/1000/665/png-clipart-computer-icons-profile-s-free-angle-sphere-thumbnail.png"
    alt="Avatar" class="rounded-full {{ $size }}">
@endif