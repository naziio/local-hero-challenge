<template>
    <div class="container">
        <h1>Select Multiple</h1>
        <div class="row justify-content-center">
            <div class="col-md-12">
               <selected-component @clicked="onClickChild"></selected-component>
            </div>
            <div class="col-md-12">
                <table-business-component v-if="businesses" :businesses="businesses"> </table-business-component>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
      
import SelectedComponent from './business/SelectedComponent.vue'
import TableBusinessComponent from './business/TableBusinessComponent.vue'
   export default {
      components: {
          SelectedComponent,
          TableBusinessComponent
       },
       data() {
           return {
               businesses: '',
               message:''
                  }
              },
      methods : {
           onClickChild (value) {
             this.businesses = value;
            },
          getData(){
                 axios.get('/api/getData')
                 .then((response) => {
                  if(response.data){
                        this.businesses = response.data
                        this.message = 'Data successfully'
                      }else{
                        this.message = 'Data error'
                      }
                 })
                .catch((err) => {
                   console.log(err)
                })
         },
        },
      
     created: function () {
            this.getData()
        },
       
             
     }
   


</script>