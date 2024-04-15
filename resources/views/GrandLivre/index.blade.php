@extends('layouts.tabler')

@section('content')
<div class="page-body">
    <div class="container-fluid">
        <!-- Bouton de téléchargement PDF -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Entries</h2>
            <a href="{{ route('grand.generate-pdf') }}" class="btn btn-primary">Download PDF</a>
        </div>

        <!-- Form to add a new entry -->
        <form action="{{ route('grand-livre.store') }}" method="post">
            @csrf
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="date">Date:</label>
                    <input type="date" name="date" id="date" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="description">Description:</label>
                    <input type="text" name="description" id="description" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="compte_debit">Debited Account:</label>
                    <input type="text" name="compte_debit" id="compte_debit" class="form-control" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="compte_credit">Credited Account:</label>
                    <input type="text" name="compte_credit" id="compte_credit" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="montant">Amount:</label>
                    <input type="number" name="montant" id="montant" class="form-control" step="0.01" required>
                </div>
            </div>
            <input type="hidden" name="journal" value="default_value"> <!-- Hidden journal field -->
            <div class="text-end">
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>

        <!-- Table to display entries -->
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Debited Account</th>
                    <th>Credited Account</th>
                    <th>Amount</th>
                    <th>Running Balance</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalAmount = 0; // Initialize total amount
                    $runningBalance = 0; // Initialize running balance
                @endphp
                @foreach ($entries as $entry)
                    <tr>
                        <td>{{ $entry->date }}</td>
                        <td>{{ $entry->description }}</td>
                        <td>{{ $entry->compte_debit }}</td>
                        <td>{{ $entry->compte_credit }}</td>
                        <td>{{ $entry->montant }}</td>
                        <td>{{ $runningBalance += $entry->montant }}</td>
                    </tr>
                    @php
                        $totalAmount += $entry->montant; // Add entry amount to total
                    @endphp
                @endforeach
            </tbody>
        </table>

        <!-- Display totals and final balance -->
        <div class="text-end">
            <p><strong>Total Amount: </strong>{{ $totalAmount }}</p>
            <p><strong>Final Balance: </strong>{{ $runningBalance }}</p>
        </div>

        @if ($entries->isEmpty())
            <p>No entries found in the ledger.</p>
        @endif
    </div>
</div>
@endsection
