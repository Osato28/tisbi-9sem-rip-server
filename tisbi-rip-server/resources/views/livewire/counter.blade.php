<div>
    <h1>{{$count}}</h1>
    <button wire:click="increment">+</button>
    <button wire:click="decrement">-</button>
    <input type="text" id="count" wire:model.live="count">
</div>
