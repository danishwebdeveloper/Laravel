@if (count($data) > 0)
<table class="table tbl-border tbl-red my-2">
    <tr>
      @if ($data['red_heading'] !="")
             <td class="bg-red"><h3>{{ $data['red_heading'] }}</h3></td>
      @endif
    </tr>
    <tr>
      <td class="box-content">
       @if ($data['red_body'] !="")
         {!! $data['red_body'] !!}
       @endif
      </td>
    </tr>
</table>
@endif

