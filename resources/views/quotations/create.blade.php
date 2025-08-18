@extends('layouts.app')
@section('title', 'Create Quotation')
@section('content')
    <h1>Create Quotation</h1>
    <form method="POST" action="{{ route('quotations.store') }}">
        @csrf
        <div class="mb-3">
            <label>Client</label>
            <select name="client_id" class="form-control" required>
                <option value="">Select a client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                        {{ $client->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <h5>Items</h5>
        <div id="items-list">
            @if(old('items'))
                @foreach(old('items') as $i => $qitem)
                    <div class="row item-row mb-2">
                        <div class="col-md-5">
                            <select name="items[{{ $i }}][item_id]" class="form-control" required>
                                <option value="">Select Item</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ $qitem['item_id'] == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }} (₨{{ $item->price }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" name="items[{{ $i }}][qty]" class="form-control" value="{{ $qitem['qty'] }}"
                                min="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="row item-row mb-2">
                    <div class="col-md-5">
                        <select name="items[0][item_id]" class="form-control" required>
                            <option value="">Select Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->name }} (₨{{ $item->price }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="items[0][qty]" class="form-control" value="1" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                </div>
            @endif
        </div>
        <button type="button" class="btn btn-info mb-3" id="add-item">Add Item</button>
        <br>
        <button type="submit" class="btn btn-success">Create Quotation</button>
        <a href="{{ route('quotations.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
    <script>
        let itemsIndex = document.querySelectorAll('.item-row').length;
        document.getElementById('add-item').addEventListener('click', function () {
            let itemsList = document.getElementById('items-list');
            let html = `<div class="row item-row mb-2">
                                                            <div class="col-md-5">
                                                                <select name="items[${itemsIndex}][item_id]" class="form-control" required>
                                                                    <option value="">Select Item</option>
                                                                    @foreach($items as $item)
                                                                        <option value="{{ $item->id }}">{{ $item->name }} (₨{{ $item->price }})</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <input type="number" name="items[${itemsIndex}][qty]" class="form-control" value="1" min="1" required>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button" class="btn btn-danger remove-item">Remove</button>
                                                            </div>
                                                        </div>`;
            itemsList.insertAdjacentHTML('beforeend', html);
            itemsIndex++;
        });
        document.addEventListener('click', function (e) {
            if (e.target && e.target.classList.contains('remove-item')) {
                e.target.closest('.item-row').remove();
            }
        });
    </script>
@endsection