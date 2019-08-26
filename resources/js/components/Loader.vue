<template>
  <div class="text-xs-center">
    <v-dialog
      v-model="dialog"
      hide-overlay
      persistent
      width="300"
    >
      <v-card
        color="primary"
        dark
      >
        <v-card-text>
          Please stand by
          <v-progress-linear
            indeterminate
            color="white"
            class="mb-0"
          ></v-progress-linear>
        </v-card-text>
      </v-card>
    </v-dialog>
  </div>
</template>
<script>
  export default {
    created() {
      this.listen();
    },
    data () {
      return {
        dialog: false
      }
    },

    watch: {
      dialog (val) {
        if (!val) return

        setTimeout(() => (this.dialog = false), 4000)
      }
    },
    methods: {
        listen() {
            EventBus.$on('ShowLoading', ()=> {
                this.dialog = true;
                //console.log('Show Loading...')
            });
            EventBus.$on('CloseLoading', ()=> {
                this.dialog = false;
                //console.log('Close Loading...')
            });
      }
    }
  }
</script>


