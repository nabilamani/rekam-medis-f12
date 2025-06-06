<main class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <livewire:medical-record.card-patient />
    <livewire:medical-record.card-record />
    <livewire:medical-record.card-prescription />
    <section class="w-full border border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 overflow-hidden shadow-sm rounded-lg md:rounded-2xl p-6 md:px-8">
        <div class="flex flex-col md:flex-row justify-end gap-4">
            @if (request()->user()->is_editor)
                <flux:button variant="primary" class="cursor-pointer" wire:click="storeAndPrint">{{ __('save') }} & Print</flux:button>
                <flux:button variant="primary" class="cursor-pointer" wire:click="storeData">{{ __('medical_record.save') }}</flux:button>
            @endif
            <flux:button @click="window.history.back()" class="cursor-pointer" wire:navigate>{{ __('cancel') }}</flux:button>
        </div>
    </section>
</main>

@script
    <script>
        $wire.on('printRecord', (record_id) => {
            window.open(`{{ route('record.print.detail', '__record_id__') }}`.replace('__record_id__', record_id));
        });
    </script>
@endscript