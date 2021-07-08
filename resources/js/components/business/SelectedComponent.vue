<template>
   <v-select @input="updateMe($event)" multiple v-model="selected"  :options="['Gym','Hotel','Restaurant']" />
</template>

 <script type="text/javascript">
      import vSelect from "vue-select";
      import "vue-select/dist/vue-select.css";

   export default {
      components: {
        vSelect
       },
       data() {
           return {
             selected:[],
             
           }
       },
      methods : {
        updateMe(event) {
         this.getData(event)
        },
           getData(event){
                 axios.get('/api/dataSelected', {
                  params: {
                    data: event
                  }
                }).then((response) => {
                  this.$emit('clicked',response.data)
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
    }

</script>

