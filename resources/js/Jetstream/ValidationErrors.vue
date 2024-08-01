<template>
    <div class="alert alert-danger text-sm text-white p-2" role="alert" v-if="hasErrors">
        <div class="font-weight-bold border-bottom mb-2">
          Ups! Algo no está bien.
        </div>

        <ul class="list-unstyled">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>
</template>

<script>
import { defineComponent } from 'vue'

export default defineComponent({
  computed: {
    errors () {
      return this.$page.props.errors
    },

    hasErrors () {
      return Object.keys(this.errors).length > 0
    },
  },
})
</script>
