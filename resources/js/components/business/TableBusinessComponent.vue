<template>
      <main>
          <div class="row pt-5 pb-3">
        <div class="col-md-6">
          <h4 class="b-500">Businesses Sales guy</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-12 table-responsive">
          <table id="tableA" class="table table-striped table-bordered table-sm z-depth-1-half" cellspacing="0" width="100%">
            <thead>
              <tr>
                <th class="th-sm">Business</th>
                <th class="th-sm">People</th>
                <th class="th-sm">Quantity</th>
                <th class="th-sm">Termine</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="businessSalesGuy in businesses" :key="businessSalesGuy.id">
                <td>{{businessSalesGuy.business}}</td>
                <th scope="row">{{businessSalesGuy.people}}</th>
                <td>{{businessSalesGuy.quantity}}</td>
                
                <td>{{businessSalesGuy.termin}}</td>
              </tr>
            </tbody>
             <tfoot>
              <tr>
                <th class="th-sm"></th>
                <th class="th-sm"></th>
                <th class="th-sm"></th>
                <th class="th-sm"></th>
              </tr>
             </tfoot>
          </table>
        </div>
        </div>
    </main>
</template>

<script type="text/javascript">
      
$(document).ready(function() {
    $('#tableA').dataTable({
    	"footerCallback": function( tfoot, data, start, end, display ) {
           var api = this.api(), data;
           var intVal = function ( i ) {
               return typeof i === 'string' ?
                   i.replace(/[\$,]/g, '')*1 :
                   typeof i === 'number' ?
                       i : 0;
           };

           var amtTotal = api
               .column( 3 , {page:'current'})
               .data()
               .reduce( function (a, b) {
                   return intVal(a) + intVal(b);
               }, 0 );
        $(tfoot).find('th').eq(3).html(amtTotal );
         var amtTotal1 = api
               .column( 1 , {page:'current'})
               .data()
               .reduce( function (a, b) {
                   return intVal(a) + intVal(b);
               }, 0 );
        $(tfoot).find('th').eq(1).html(amtTotal1 );
         var amtTotal2 = api
               .column( 2 , {page:'current'} )
               .data()
               .reduce( function (a, b) {
                   return intVal(a) + intVal(b);
               }, 0 );
        $(tfoot).find('th').eq(2).html(amtTotal2 );
       
      },
    } );
} );

   export default {
      components: {

       },
       props:['businesses'],
       data() {
           return {
              
                  }
              },

    }
</script>

