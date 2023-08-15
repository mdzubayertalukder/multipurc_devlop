@extends('layouts.backend.app')

@section('title','My websites')

@section('head')
@include('layouts.backend.partials.headersection',['title'=>'Store Product'])
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
                    <form method="post" action="{{ route('seller.products.destroys') }}" class="ajaxform_with_reload">
                        @csrf
                        <div class="float-left">
                            <div class="input-group">
                                <select class="form-control selectric" name="method">
                                    <option disabled selected="">{{ __('Select Action') }}</option>
                                    <option value="1">{{ __('Publish Now') }}</option>
                                    <option value="0">{{ __('Draft') }}</option>
                                    
                                   
                                    <option value="delete" class="text-danger">{{ __('Delete Permanently') }}</option>
                                   
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
                                        
                                        <th>{{ __('Domain') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th class="text-right"><i class="far fa-image"></i></th>
                                        <th class="text-right">{{ __('Type') }}</th>
                                        <th class="text-right">{{ __('Price') }}</th>
                                        <th class="text-right">{{ __('Status') }}</th>
                                        <th class="text-right">{{ __('Sales') }}</th>
                                        <th class="text-right">{{ __('Rating') }}</th>
                                        <th class="text-right">{{ __('Created At') }}</th>
                                        <th class="text-right">{{ __('Import') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_products as $products)
                    
                                 
                                        @foreach($products as $row)
                                   
                                       
                                            <tr id="row{{  $row->id }}">
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="ids[]" class="custom-control-input" id="customCheck{{ $row->id }}" value="{{ $row->id }}">
                                                        <label class="custom-control-label" for="customCheck{{ $row->id }}"></label>
                                                    </div>
                                                </td>
                                                  <td>{{ $row->domain_url??''}}</td>
                                                  <td><span>{{ $row->domain_url.'/product/'.$row->slug }}</span></td>
                                                  <td class="text-right"><img src="{{ asset($row->value ?? 'uploads/default.png') }}" height="50" alt=""></td>
                                                  <td class="text-right">{{ $row->is_variation == 1 ? 'Variations' : 'Simple'  }}</td>
                                                  <td class="text-right">{{$row->price ?? '' }}{{ $row->is_variation == 1 ? '*' : ''  }}</td>
                                                  <td class="text-right"><span class="badge badge-{{ $row->status == 1 ? 'success' : 'danger' }}">{{ $row->status == 1 ? 'Active' : 'Disable' }}</span></td>
                                                  <td>{{ $row->orderitem_count??0 }}</td>
                                                  <td><span>{{ isset($row->rating) ? $row->rating:0 }}</span></td>
                                                  <td class="text-right">{{ date('d-m-Y', strtotime($row->created_at)) }}</td>
                                                  <td class="text-right">
                                                    <a class="text-light badge badge-success" href="{{ route('merchant.domain.import', ['id'=>$row->term_id,'domain'=>$row->domain]) }}">{{ isset($row->is_seller) ? (($row->is_seller==1) ? 'Imported' :'Import'):''; }} </i></a>
                                                </td>
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