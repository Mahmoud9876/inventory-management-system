<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">
                {{ __('Contracts') }}
            </h3>
        </div>

        <div class="card-actions">
            <x-action.create route="{{ route('contracts.create') }}" />
        </div>
    </div>

    <div class="card-body border-bottom py-3">
        <div class="d-flex">
            <div class="text-secondary">
                Show
                <div class="mx-2 d-inline-block">
                   
                </div>
                entries
            </div>
            <div class="ms-auto text-secondary">
                Search:
                <div class="ms-2 d-inline-block">
                </div>
            </div>
        </div>
    </div>

    <x-spinner.loading-spinner/>

    <div class="table-responsive">
        <table wire:loading.remove class="table table-bordered card-table table-vcenter text-nowrap datatable">
            <thead class="thead-light">
                <tr>
                    <th class="align-middle text-center w-1">
                        {{ __('No.') }}
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('contract_id')" href="#" role="button">
                            {{ __('Contract No.') }}
                            @include('includes._sort-icon', ['field' => 'contract_id'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('supplier_id')" href="#" role="button">
                            {{ __('Supplier') }}
                            @include('includes._sort-icon', ['field' => 'supplier_id'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('start_date')" href="#" role="button">
                            {{ __('Start Date') }}
                            @include('includes._sort-icon', ['field' => 'start_date'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('total_amount')" href="#" role="button">
                            {{ __('Total') }}
                            @include('includes._sort-icon', ['field' => 'total_amount'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        <a wire:click.prevent="sortBy('contract_status')" href="#" role="button">
                            {{ __('Status') }}
                            @include('includes._sort-icon', ['field' => 'contract_status'])
                        </a>
                    </th>
                    <th scope="col" class="align-middle text-center">
                        {{ __('Action') }}
                    </th>
                </tr>
            </thead>
            <tbody>
            @forelse ($contracts as $contract)
                <tr>
                    <td class="align-middle text-center">
                        {{ $loop->iteration }}
                    </td>
                    <td class="align-middle text-center">
                        {{ $contract->contract_id }}
                    </td>
                    <td class="align-middle text-center">
                        {{ $contract->supplier->name }}
                    </td>
                    <td class="align-middle text-center">
                        {{ $contract->start_date->format('d-m-Y') }}
                    </td>
                    <td class="align-middle text-center">
                        {{ Number::currency($contract->total_amount, 'EUR') }}
                    </td>

                    @if ($contract->contract_status === 'APPROVED')
                        <td class="align-middle text-center">
                            <span class="badge bg-green text-white text-uppercase">
                                {{ __('APPROVED') }}
                            </span>
                        </td>
                        <td class="align-middle text-center">
                            <x-button.show class="btn-icon" route="{{ route('contracts.show', $contract->id) }}"/>
                            <x-button.edit class="btn-icon" route="{{ route('contracts.edit', $contract->id) }}"/>
                        </td>
                    @else
                        <td class="align-middle text-center">
                            <span class="badge bg-orange text-white text-uppercase">
                                {{ __('PENDING') }}
                            </span>
                        </td>
                        <td class="align-middle text-center" style="width: 10%">
                            <x-button.show class="btn-icon" route="{{ route('contracts.show', $contract->id) }}"/>
                            <x-button.edit class="btn-icon" route="{{ route('contracts.edit', $contract->id) }}"/>
                            <x-button.delete class="btn-icon" onclick="return confirm('are you sure!')" route="{{ route('contracts.delete', $contract->id) }}"/>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td class="align-middle text-center" colspan="7">
                        No results found
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex align-items-center">
        <p class="m-0 text-secondary">
            Showing <span>{{ $contracts->firstItem() }}</span>
            to <span>{{ $contracts->lastItem() }}</span> of <span>{{ $contracts->total() }}</span> entries
        </p>

        <ul class="pagination m-0 ms-auto">
            {{ $contracts->links() }}
        </ul>
    </div>
</div>