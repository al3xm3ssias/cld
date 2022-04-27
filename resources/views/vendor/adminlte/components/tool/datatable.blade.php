{{-- Table --}}

<div class="table">

<table id="{{ $id }}" style="width:100%" {{ $attributes->merge(['class' => $makeTableClass()]) }}>

    {{-- Table head --}}
    <thead @isset($headTheme) class="thead-{{ $headTheme }}" @endisset>
        <tr>
            @foreach($heads as $th)
                <th @isset($th['width']) style="width:{{ $th['width'] }}%" @endisset
                    @isset($th['no-export']) dt-no-export @endisset>
                    {{ is_array($th) ? ($th['label'] ?? '') : $th }}
                </th>
            @endforeach
        </tr>
    </thead>

    {{-- Table body --}}
    <tbody>{{ $slot }}</tbody>

    {{-- Table footer --}}
    @isset($withFooter)
        <tfoot @isset($footerTheme) class="thead-{{ $footerTheme }}" @endisset>
            <tr>
                @foreach($heads as $th)
                    <th>{{ is_array($th) ? ($th['label'] ?? '') : $th }}</th>
                @endforeach
            </tr>
        </tfoot>
    @endisset


</table>

</div>

{{-- Add plugin initialization and configuration code --}}

@push('js')
<script>

    /*$(() => {
        $('#{{ $id }}').DataTable( @json($config) );
            dom: 'Bfrtip',
            buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    }); */

    $(document).ready(function() {
        $('#{{ $id }}'.DataTable( {
        //dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );





</script>
@endpush

{{-- Add CSS styling --}}

@isset($beautify)
    @push('css')
    <style type="text/css">
        #{{ $id }} tr td,  #{{ $id }} tr th {
            vertical-align: middle;
            text-align: center;
        }
    </style>
    @endpush
@endisset
