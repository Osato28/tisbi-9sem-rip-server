<div class="form">
    <h1>Должность</h1>
    <form wire:submit="save" wire:delete="delete" class="flex flex-col">
        <label for="jobTitleId">Должность:</label>
        <select name="jobTitleId" id="jobTitleId" wire:model="jobTitleId">
            @foreach ($jobTitles as $jobTitle) 
                <option value="{{$jobTitle->id}}">{{$jobTitle->name}}</option>
            @endforeach
                <option value="-1">(Новая должность)</option>
        </select>
        <label for="name">Новое название:</label>
        <input type="test" name="name" id="name" wire:model="name"/>
        @error('name') <div class="error">{{$message}}</div>@enderror
        <button type="submit" class="save">Сохранить</button>
        <button type="button" wire:click="delete" class="delete">Удалить</button>
    </form>
</div>
