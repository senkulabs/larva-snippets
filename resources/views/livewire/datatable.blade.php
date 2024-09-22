<div>
    <h1 class="text-2xl">Datatable</h1>
    <h2 class="text-xl">Basic Datatable</h2>
    <p>This demo shows example of basic Datatable using Livewire</p>
    <div class="my-4">
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
                <th class="p-2 border border-slate-300">Name</th>
                <th class="p-2 border border-slate-300">Position</th>
                <th class="p-2 border border-slate-300">Office</th>
                <th class="p-2 border border-slate-300">Age</th>
                <th class="p-2 border border-slate-300">Start date</th>
                <th class="p-2 border border-slate-300">Salary</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($employees as $employee)
            <tr @class(['bg-gray-100' => ($loop->index % 2 === 0)])>
                <td class="p-2 border border-slate-300">{{ $employee->name }}</td>
                <td class="p-2 border border-slate-300">{{ $employee->position }}</td>
                <td class="p-2 border border-slate-300">{{ $employee->office }}</td>
                <td class="p-2 border border-slate-300 text-right">{{ $employee->age }}</td>
                <td class="p-2 border border-slate-300 text-right">{{ Carbon\Carbon::parse($employee->start_date)->format('jS F Y') }}</td>
                <td class="p-2 border border-slate-300 text-right">{{ $employee->salary }}</td>
            </tr>
            @empty
            <tr>
                <td class="p-2 text-center bg-gray-100" colspan="6">No record found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="mt-4">
        {{ $employees->links('vendor/livewire/custom-tailwind', [
            'grand_total' => \App\Models\Employee::count(),
            'search' => $this->search
        ]) }}
    </div>
</div>
