<div class="form">
    @if ($mode == 'edit')
        <h1>Редактирование премии работника {{$this->bonus->employee->name}}</h1>
    @elseif ($mode == 'create')
        <h1>Новая премия</h1>
    @endif
    @if ($mode == 'edit' || $mode == 'create')
    <form wire:submit="save" class="flex flex-col">
        <label for="date">Дата:</label>
        <input type="date" name="date" wire:model="date" id="date">
        @error('date') <div class="error">{{$message}}</div>@enderror
        <label for="sum">Сумма, ₽:</label>
        <input type="number" name="sum" wire:model="sum" id="sum" step="0.01">
        @error('sum') <div class="error">{{$message}}</div>@enderror
        <label for="employeeId">Работник:</label>
        <select name="employeeId" wire:model="employeeId">
            @foreach ($employees as $employee)
            <option value="{{$employee->id}}">{{$employee->name}}</option>
            @endforeach
        </select>
        <button type="submit" class="save">Сохранить</button>
    </form>
    @endif
</div>
