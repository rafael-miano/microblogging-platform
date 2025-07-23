@props(['post', 'hasUpReact'])

@php
    $canReact = auth()->id() !== $post->user_id;
@endphp

<div
    x-data="upReactComponent({{ $post->id }}, {{ $canReact ? 'true' : 'false' }}, {{ $hasUpReact ? 'true' : 'false' }}, {{ $post->up_reacts_count }})"
    class="mt-0 p-2"
>
    <button
        :disabled="!canReact"
        @click="toggleReact"
        class="flex mb-2 gap-2 text-gray-500 text-sm hover:text-gray-900 disabled:cursor-not-allowed disabled:opacity-60"
    >
        <template x-if="!hasUpReact">
            <x-bx-upvote class="w-5 h-5 text-gray-500 hover:text-gray-900" />
        </template>
        <template x-if="hasUpReact">
            <x-bxs-upvote class="w-5 h-5 text-gray-500 hover:text-gray-900" />
        </template>
        <span x-text="count"></span>
    </button>
</div>

<script>
    function upReactComponent(postId, canReact, hasUpReactInitial, initialCount) {
        return {
            canReact,
            hasUpReact: hasUpReactInitial,
            count: initialCount,
            toggleReact() {
                if (!this.canReact) return;

                axios.post(`/up-react/${postId}`)
                    .then(response => {
                        this.hasUpReact = !this.hasUpReact;
                        this.count = response.data.upReactCounts;
                    })
                    .catch(err => console.error(err));
            }
        };
    }
</script>
