<div>
    <div>
        <label>
            <select wire:model.change="perPage">
                <option>10</option>
                <option>25</option>
                <option>50</option>
                <option>100</option>
            </select>
            entries per page
        </label>
        <input type="text" wire:model.change="search">
    </div>
    <table class="w-full table-auto border-collapse border border-slate-400">
        <thead>
            <tr>
                <th class="border border-slate-300">Name</th>
                <th class="border border-slate-300">Position</th>
                <th class="border border-slate-300">Office</th>
                <th class="border border-slate-300">Age</th>
                <th class="border border-slate-300">Start date</th>
                <th class="border border-slate-300">Salary</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td class="border border-slate-300">{{ $employee->name }}</td>
                <td class="border border-slate-300">{{ $employee->position }}</td>
                <td class="border border-slate-300">{{ $employee->office }}</td>
                <td class="border border-slate-300 text-right">{{ $employee->age }}</td>
                <td class="border border-slate-300 text-center">{{ $employee->start_date }}</td>
                <td class="border border-slate-300 text-right">{{ $employee->salary }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="mt-4">
        {{ $employees->links() }}
    </div>
</div>
