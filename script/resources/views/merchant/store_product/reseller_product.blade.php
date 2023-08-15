@extends('layouts.backend.app')

@section('title','My websites')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Reseller Product'])
@endsection

@section('content')
<style>
    .link-style {
        color: blue;
        text-decoration: underline;
        cursor: pointer;
    }
</style>
<div class="row">
	<div class="col-12">
		<div class="card">
			@if (Session::has('message') || Session::has('success'))
    			<div class="card-header">
    				@if (Session::has('success'))
    				<div class="alert alert-success">
    					{{ Session::get('success') }}
    				</div>
    				@endif
    
    				@if (Session::has('message'))
    				<div class="col-12 col-md-12 col-lg-12">
    					<div class="alert alert-{{ Session::get('type') }}">{{ Session::get('message') }}</div>
    				</div>
    				@endif
    			</div>
    			@endif
        		 <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <a href="#" class="btn btn-primary float-right" data-toggle="modal" data-target="#import">{{ __('Bulk Import') }}</a>
                        </div>
                    </div>
                    <br>
                    <div class="float-right">
                        <form>
                            <div class="input-group mb-2">
            
                                <input type="text" id="src" class="form-control" placeholder="Search..." required="" name="src" autocomplete="off" value="{{ $request->src ?? '' }}">
                                <select class="form-control selectric" name="type" id="type">
                                   
                                    {{--<option value="full_id" @if($type == 'full_id') selected @endif>{{ __('Search By Id') }}</option>
                                    <option value="title" @if($type == 'title') selected @endif>{{ __('Search By Name') }}</option>--}}
                                </select>
                                <div class="input-group-append">                                            
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <form method="post" action="{{ route('merchant.reseller.product.add') }}" class="ajaxform_with_reload">
                        @csrf
                       
                         <div class="float-left ml-4">
                            <div class="input-group">
                                <select class="form-control selectric" name="domain" required>
                                    <option disabled selected="">{{ __('Select Domain') }}</option>
                                    
                                    @foreach($tenants as $tenant)
                                    <option value="{{ $tenant->id }}">{{ $tenant->id }}</option>
                                    @endforeach
                                    
                                </select>
                                <div class="input-group-append">                                            
                                    <button class="btn btn-primary basicbtn" type="submit">{{ __('Submit') }}</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive custom-table">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="am-select">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input checkAll" id="selectAll">
                                                <label class="custom-control-label checkAll" for="selectAll"></label>
                                            </div>
                                        </th>
                                        
                                         <th>{{ __('Product Name') }}</th>
                                        <th>{{ __('Domain') }}</th>
                                      
                                        <th class="text-right"><i class="far fa-image"></i></th>
                                        <th class="text-right">{{ __('Price') }}</th>
                                        <th class="text-right">{{ __('Add Custom Price') }}</th>
                                        <th class="text-right">{{ __('Sales') }}</th>
                                        <th class="text-right">{{ __('Rating') }}</th>
                                                                       </tr>
                                </thead>
                                <tbody>
                                   @foreach($all_products as $outerIndex => $products)
                                        @foreach($products as $innerIndex => $row)
                                            <tr id="row{{ $outerIndex }}_{{ $innerIndex }}">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="product_name[]" class="custom-control-input" id="customCheck{{ $outerIndex }}_{{ $innerIndex }}" value="{{ $row->title }}">
                                                     
                                                        <input type="hidden" name="img[]" class="custom-control-input" value="{{ $row->value }}">
                                                        <label class="custom-control-label" for="customCheck{{ $outerIndex }}_{{ $innerIndex }}"></label>
                                                    </div>
                                                </td>
                                                <td><span>{{ $row->title }}</span></td>
                                                <td><span>{{ $row->domain.'/product/'.$row->slug }}</span></td>
                                                <td class="text-right"><img src="{{ asset($row->value ?? 'uploads/default.png') }}" height="50" alt=""></td>
                                           
                                                <td class="text-right">{{$row->price ?? '' }}{{ $row->is_variation == 1 ? '*' : ''  }}</td>
                                                <td class="text-right"><input type="number" class="form-control" name="price[]"></td>
                                                <td><span style="margin-left: 17px;">{{ $row->orderitem_count }}</span></td>
                                                <td><span>{{ isset($row->rating) ? $row->rating:0 }}</span></td>
    
                                            </tr>  
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </form>
                      
                    </div>
                </div>
			</div>
		</div> 
	</div>
</div>
@endsection

@push('script')
<script src="{{ asset('admin/js/merchant.js') }}"></script>
@endpush