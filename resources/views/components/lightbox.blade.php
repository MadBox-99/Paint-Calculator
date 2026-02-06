<div
    x-data="{
        open: false,
        images: [],
        current: 0,
        touchStartX: 0,
        touchEndX: 0,
        show(imgs, index = 0) {
            this.images = imgs;
            this.current = index;
            this.open = true;
            document.body.classList.add('overflow-hidden');
        },
        close() {
            this.open = false;
            document.body.classList.remove('overflow-hidden');
        },
        next() {
            this.current = (this.current + 1) % this.images.length;
        },
        prev() {
            this.current = (this.current - 1 + this.images.length) % this.images.length;
        },
        onTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
        },
        onTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].screenX;
            const diff = this.touchStartX - this.touchEndX;
            if (Math.abs(diff) > 50) {
                diff > 0 ? this.next() : this.prev();
            }
        }
    }"
    x-on:open-lightbox.window="show($event.detail.images, $event.detail.index || 0)"
    x-on:keydown.escape.window="close()"
    x-on:keydown.arrow-right.window="open && next()"
    x-on:keydown.arrow-left.window="open && prev()"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-50 flex items-center justify-center"
    style="display: none;"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-black/80"
        x-on:click="close()"
    ></div>

    {{-- Content --}}
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="relative z-10 flex items-center justify-center w-full max-w-4xl px-4"
        x-on:touchstart="onTouchStart($event)"
        x-on:touchend="onTouchEnd($event)"
    >
        {{-- Close button --}}
        <button
            x-on:click="close()"
            class="absolute z-20 flex items-center justify-center w-10 h-10 text-white bg-black/50 rounded-full top-4 right-4 hover:bg-black/70"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        {{-- Previous button --}}
        <button
            x-show="images.length > 1"
            x-on:click.stop="prev()"
            class="absolute left-2 sm:left-6 z-20 flex items-center justify-center w-10 h-10 text-white bg-black/50 rounded-full hover:bg-black/70"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </button>

        {{-- Image --}}
        <img
            x-bind:src="images[current]"
            x-bind:alt="'Kép ' + (current + 1) + ' / ' + images.length"
            class="object-contain max-h-[85vh] max-w-full rounded-lg shadow-2xl"
            x-on:click.stop
        />

        {{-- Next button --}}
        <button
            x-show="images.length > 1"
            x-on:click.stop="next()"
            class="absolute right-2 sm:right-6 z-20 flex items-center justify-center w-10 h-10 text-white bg-black/50 rounded-full hover:bg-black/70"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </button>

        {{-- Counter --}}
        <div
            x-show="images.length > 1"
            class="absolute bottom-4 left-1/2 -translate-x-1/2 px-3 py-1 text-sm text-white bg-black/50 rounded-full"
            x-text="(current + 1) + ' / ' + images.length"
        ></div>
    </div>
</div>
