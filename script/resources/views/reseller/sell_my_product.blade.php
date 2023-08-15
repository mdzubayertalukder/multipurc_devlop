@extends('layouts.backend.app')



@section('content')
<section class="section">
            <div class="section-header">
	  <h1>Sell My Product</h1>
    <div class="section-header-breadcrumb">
  	        <div class="breadcrumb-item"></div>
            <div class="breadcrumb-item"></div>
        </div>
</div>      </section>
<div class="row">
    <div class="col-12">
       
        <div class="card">
            <div class="card-body">
               
                <div class="row">
                   
                    <div class="col-6 mt-4">
                        <form action="{{ url('/seller/show_product') }}" method="get">
                            @csrf
                            <div class="input-group form-row mt-3">

                                
                                <select class="form-control" name="store">
                                    	@foreach($posts as $row)
                                    <option value="{{ $row->id }}">{{ $row->id }}</option>
                            
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
               
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
                
               
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('admin/js/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('admin/js/form.js') }}"></script>
<script src="{{ asset('theme/jquery.unveil.js') }}"></script>
<script src="{{ asset('theme/resto/js/products.js') }}"></script>
@endpush
