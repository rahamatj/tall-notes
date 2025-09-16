<?php

use Livewire\Volt\Component;
use \Illuminate\Support\Facades\Auth;
use App\Models\Note;

new class extends Component {
    public function with()
    {
        return [
            'notes' => Auth::user()->notes()->orderBy('send_date', 'asc')->get(),
        ];
    }

    public function delete($id)
    {
        $this->authorize('delete', Note::find($id));

        Note::find($id)?->delete();
    }
}; ?>

<div class="space-y-2">
    @if($notes->isEmpty())
        <div class="alert alert-info">
            No notes available.
        </div>
        <x-mary:button href="{{ route('notes.create') }}" label="Create Note" class="btn-primary" wire:navigate/>
    @else
        <div class="grid grid-cols-2 gap-4 mt-12">
            @foreach($notes as $note)
                <x-mary:card wire:key="{{ $note->id }}">
                    <div class="flex justify-between shadow p-3 rounded">
                        <div>
                            <a href="{{ route('notes.edit', $note) }}" class="text-xl font-bold hover:underline hover:text-blue-500" wire:navigate>
                                {{ $note->title }}
                            </a>
                            <p class="text-xs mt-2">{{ Str::limit($note->body, 50) }}</p>
                            <div class="text-xs text-gray-500">{{ $note->send_date->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="flex items-end justify-between mt-4 space-x-2">
                        <p class="text-xs">Recipient: <span class="font-semibold">{{ $note->recipient }}</span></p>

                        <div>
                            <x-mary:button label="View" class="btn-primary text-white"/>
                            <x-mary:button label="Delete" class="btn-error" wire:click="delete('{{ $note->id }}')"/>
                        </div>
                    </div>
                </x-mary:card>
            @endforeach
        </div>
    @endif
</div>
