<div class="form">
    @if ($mode == 'edit' || $mode == 'show')
    <h1>Работник: {{$employee->name}}</h1>
    @elseif ($mode == 'create')
    <h1>Новый работник</h1>
    @endif

    <h2>Данные работника</h2>
    @if ($mode == 'edit' || $mode == 'create')
    <form wire:submit="save" class="flex flex-col items-start">
        <label for="name">Имя:</label>
        <input type="text" name="name" wire:model="name" id="name">
        @error('name') <div class="error">{{$message}}</div>@enderror
        <label for="salary">Зарплата, ₽:</label>
        <input type="text" name="salary" wire:model="salary" id="salary">
        @error('salary') <div class="error">{{$message}}</div>@enderror
        <label for="jobTitleId">Должность:</label>
        <select name="jobTitleId" wire:model="jobTitleId">
            <option value="-1">(Не выбрано)</option>
            @foreach ($jobTitles as $jobTitle)
            <option value="{{$jobTitle->id}}">{{$jobTitle->name}}</option>
            @endforeach
        </select>
        @error('jobTitleId') <div class="error">{{$message}}</div>@enderror
        <button type="submit" class="save">Сохранить</button>
    </form>
    @elseif ($mode == 'show')
        <div class="label">Имя:</div>
        <div>{{$employee->name}}</div>
        <div class="label">Зарплата:</div>
        <div>{{number_format($employee->salary, 2)}} ₽</div>
        <div class="label">Должность:</div>
        <div>{{$employee->jobTitle ? $employee->jobTitle->name : "(Не указана)"}}</div>
    @endif

    @if ($mode != 'create')
    <h2>Премии</h2>
    <table>
        <tr>
        <th>Дата</th>
        <th>Сумма</th>
        @if ($mode == 'edit')
        <th>Действия</th>
        @endif
        </tr>
        @foreach ($employee->bonuses as $bonus)
        <tr wire:key="{{$bonus->id}}">
            <td>
                {{$bonus->date}}
            </td>
            <td>{{number_format($bonus->sum, 2)}} ₽</td>
            @if ($mode == 'edit')
                <td>
                    <button wire:click="editBonus({{$bonus->id}})" class="edit">Редактировать</button>
                    <button wire:click="deleteBonus({{$bonus->id}})" class="delete">Удалить</button>
                </td>
            @endif
        </tr>
        @endforeach
    </table>
    @if ($mode == 'edit')
        <button wire:click="createBonus" class="create">Добавить премию</button>
    @endif
    @endif
</div>
