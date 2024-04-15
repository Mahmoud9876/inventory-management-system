@extends('layouts.tabler')

@section('content')
<div class="page-body">
    @if(!$contracts)
    <x-empty
        title="No Contracts found"
        message="Try adjusting your search or filter to find what you're looking for."
        button_label="{{ __('Add your first Contract') }}"
        button_route="{{ route('Contracts.create') }}"
    />
    @else
    <div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                Contracts
            </h3>
        </div>

        <div class="card-actions">
            <!-- Your create action button -->
        </div>
    </div>

    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="text-secondary">
                Show
                <div class="mx-2 d-inline-block">
                    <!-- Your entries select dropdown -->
                </div>
                entries
            </div>
            <div class="ms-auto text-secondary">
                Search:
                <div class="ms-2 d-inline-block">
                    <!-- Your search input -->
                </div>
            </div>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered card-table table-vcenter text-nowrap datatable">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center w-1">
                        No.
                    </th>
                    <th scope="col" class="align-middle text-center">
                        Contract No.
                    </th>
                    <th scope="col" class="align-middle text-center">
                        Supplier
                    </th>
                    <th scope="col" class="align-middle text-center">
                        Start Date
                    </th>
                    <th scope="col" class="align-middle text-center">
                        End Date
                    </th>
                    <th scope="col" class="align-middle text-center">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
            <tbody>
    @forelse ($contracts as $contract)
        <tr>
            <td class="align-middle text-center">
                {{ $loop->iteration }}
            </td>
            <td class="align-middle text-center">
                {{ $contract->id }}
            </td>
            <td class="align-middle text-center">
                {{ $contract->supplier->name }}
            </td>
            <td class="align-middle text-center">
                {{ $contract->start_date }}
            </td>
            <td class="align-middle text-center">
                {{ $contract->end_date }}
            </td>
            <td class="align-middle text-center">
            <button class="btn-icon" onclick="window.location.href='{{ route('contracts.show', $contract->id) }}'">Show</button>
<button class="btn-icon" onclick="window.location.href='{{ route('contracts.edit', $contract->id) }}'">Edit</button>
            </td>
        </tr>
    @empty
        <tr>
            <td class="align-middle text-center" colspan="7">
                No results found
            </td>
        </tr>
    @endforelse
</tbody>

            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <span></span> to <span></span> of <span></span> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            <!-- Your pagination links -->
        </ul>
    </div>
</div>

            
    @endif
    <div>
</div>
@endsection
