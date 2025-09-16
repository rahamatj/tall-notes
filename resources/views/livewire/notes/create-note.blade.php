<?php

use Livewire\Volt\Component;

new class extends Component {
    public $title;
    public $body;
    public $recipient;
    public $send_date;

    public function submit() {
        $validated = $this->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'recipient' => 'required|email|max:255',
            'send_date' => 'required|date',
        ]);

        auth()->user()->notes()->create($validated);

        redirect(route('notes.index'));
    }
}; ?>

<div>
    <form wire:submit.prevent="submit" class="space-y-4">
        <x-mary:input label="Title" placeholder="Enter title" wire:model="title" />
        <x-mary:textarea label="Body" placeholder="Enter body" wire:model="body" />
        <x-mary:input label="Recipient" placeholder="Enter recipient" wire:model="recipient" />
        <x-mary:input type="date" label="Send Date" placeholder="Select send date" wire:model="send_date" />

        <x-mary:button label="Create Note" class="btn-primary mt-4" wire:click.prevent="submit" />
    </form>
</div>
