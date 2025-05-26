<div class="form">
    <h1>Работники</h1>
    <table>               
        <tr>
            <th>Имя</th>
            <th>Должность</th>
            <th>Зарплата</th>
            <th>Суммарно премий</th>
            @if ($mode == 'edit')
            <th>Действия</th>
            @endif
        </tr>
        @foreach ($employees as $employee)
            <tr wire:key="{{$employee->id}}">
                <td><a href="#" wire:click="show({{$employee->id}})">{{$employee->name}}</a></td>
                <td>{{$employee->jobTitle ? $employee->jobTitle->name : "(Не указана)"}}</td>
                <td>{{number_format($employee->salary), 2}} ₽</td>
                <td>{{number_format($employee->bonuses->sum('sum'), 2)}} ₽</td>
                @if ($mode == 'edit')
                <td>
                    <div class="flex flex-row flex-nowrap">
                        <button wire:click="edit({{$employee->id}})" class="edit">Редактировать</button>
                        <button wire:click="delete({{$employee->id}})" class="delete">Удалить</button>
                    </div>
                </td>
                @endif
            </tr>
        @endforeach
    </table>
    @if ($mode == 'edit')
    <button wire:click="create" class="create">Добавить работника</button>
    <button wire:click="editJobTitle" class="edit">Редактировать должности</button>
    @endif
</div>